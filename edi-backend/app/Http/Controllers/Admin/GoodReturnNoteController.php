<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodReturnNotes;
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
        $goodReturnNotes = GoodReturnNotes::orderBy('id', 'desc')->paginate(10);

        return view('admin.good-return-note.index', [
            'goodReturnNotes' => $goodReturnNotes
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
        $goodReturnNote = GoodReturnNotes::find($id);
        if (empty($goodReturnNote)) {
            return redirect()->back()->with('error_message', 'Good return note not found');
        }

        return view('admin.good-return-note.show', [
            'goodReturnNote' => $goodReturnNote
        ]);
    }
}
