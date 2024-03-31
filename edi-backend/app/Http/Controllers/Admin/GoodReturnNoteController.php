<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceiptHeader;
use App\Models\GoodsReceiptItem;
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
}
