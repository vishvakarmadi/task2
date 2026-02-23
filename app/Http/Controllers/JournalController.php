<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;

class JournalController extends Controller
{
    public function index()
    {
        $entries = JournalEntry::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('journal.index', compact('entries'));
    }
}
