<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
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
            return redirect()->back()->with('error_message', 'Invoice not found');
        }
    }
}
