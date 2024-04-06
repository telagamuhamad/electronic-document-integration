<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceiptHeader;
use App\Models\GoodsReceiptItem;
use App\Models\InvoiceItem;
use App\Models\Invoices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GoodReturnNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goodsReceiptHeaders = GoodsReceiptHeader::orderBy('id', 'desc')->paginate(10);

        return view('admin.good-return-note.index', [
            'goods_receipt_headers' => $goodsReceiptHeaders
        ]);
    }

    /**
     * Show the details of good return note
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $goodsReceiptHeader = GoodsReceiptHeader::find($id);
        if (empty($goodsReceiptHeader)) {
            return redirect()->back()->with('error_message', 'Good return note not found');
        }

        $goodsReceiptItems = GoodsReceiptItem::where('goods_receipt_id', $goodsReceiptHeader->id)->get();

        return view('admin.good-return-note.show', [
            'goods_receipt_header' => $goodsReceiptHeader,
            'goods_receipt_items' => $goodsReceiptItems
        ]);
    }

    /**
     * Convert to Invoice
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function convertToInvoice($id)
    {
        $user = auth()->user();
        $goodsReceiptHeader = GoodsReceiptHeader::find($id);
        if (empty($goodsReceiptHeader)) {
            return redirect()->back()->with('error_message', 'Tanda Terima tidak ditemukan');
        }

        $dateNow = Carbon::now()->format('Y-m-d');
        $invoice_number = 'INV-' . date('Ymd') . '-' . rand(100000, 999999);
        try {
            $invoiceHeader = new Invoices();
            $invoiceHeader->invoice_number = $invoice_number;
            $invoiceHeader->delivery_order_id = $goodsReceiptHeader->delivery_order_id;
            $invoiceHeader->goods_receipt_id = $goodsReceiptHeader->id;
            $invoiceHeader->total_cost = $goodsReceiptHeader->total_cost;
            $invoiceHeader->payment_method = $goodsReceiptHeader->payment_method;
            $invoiceHeader->payment_status = $goodsReceiptHeader->payment_status;
            $invoiceHeader->is_paid = $goodsReceiptHeader->is_paid;
            $invoiceHeader->is_delivered = $goodsReceiptHeader->is_delivered;
            $invoiceHeader->delivery_date = $goodsReceiptHeader->delivery_date;
            $invoiceHeader->received_date = $goodsReceiptHeader->received_date;
            $invoiceHeader->save();

            //Save items
            if (!empty($goodsReceiptHeader->items)) {
                foreach ($goodsReceiptHeader->items as $item) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoiceHeader->id;
                    $invoiceItem->invoice_number = $invoiceHeader->invoice_number;
                    $invoiceItem->delivery_order_id = $item->delivery_order_id;
                    $invoiceItem->delivery_order_item_id = $item->delivery_order_item_id;
                    $invoiceItem->goods_receipt_id = $item->goods_receipt_id;
                    $invoiceItem->goods_receipt_item_id = $item->id;
                    $invoiceItem->item_code = $item->item_code;
                    $invoiceItem->item_weight = $item->item_weight;
                    $invoiceItem->item_price = $item->item_price;
                    $invoiceItem->description = $item->description;
                    $invoiceItem->is_fragile = $item->is_fragile;
                    $invoiceItem->save();
                }
            }

            $goodsReceiptHeader->is_invoice_created = true;
            $goodsReceiptHeader->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.invoice.show', [
            'id' => $invoiceHeader->id
        ])->with('success_message', 'Berhasil konversi Tanda Terima menjadi Invoice');
    }
}
