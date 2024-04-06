<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use App\Models\Invoices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::orderBy('id', 'desc')->paginate(10);

        return view('admin.invoice.index', [
            'invoices' => $invoices
        ]);
    }

    /**
     * Show the details of invoice
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoices::find($id);
        if (empty($invoice)) {
            return redirect()->back()->with('error_message', 'Invoice tidak ditemukan');
        }

        $invoiceItems = InvoiceItem::where('invoice_id', $id)->get();

        return view('admin.invoice.show', [
            'invoice' => $invoice,
            'invoice_items' => $invoiceItems
        ]);
    }

    /**
     * Confirm payment of invoice
     */
    public function confirmPayment(Request $request, $id)
    {
        $invoice = Invoices::find($id);
        if (empty($invoice)) {
            return redirect()->back()->with('error_message', 'Invoice tidak ditemukan');
        }

        $dateNow = Carbon::now()->format('Y-m-d H:i:s');

        try {
            $invoice->paid_amount = $request->payment_amount;
            $invoice->payment_change = $request->payment_change_input;
            $invoice->payment_status = 'Paid';
            $invoice->payment_method = $request->payment_method;
            $invoice->is_paid = true;
            if ($request->hasFile('payment_upload')) {
                $invoice->payment_upload = $request->file('payment_upload')->store('invoice/payment_upload/'.$invoice->invoice_number);
            }
            $invoice->payment_date = $dateNow;
            $invoice->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->back()->with('success_message', 'Berhasil bayar invoice');
    }
}
