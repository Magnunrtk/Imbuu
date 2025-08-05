<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BazaarHist; 

class BazaarController extends Controller
{
    public function index()
    {

        $bazaarData = BazaarHist::select('coins', 'date')->get();

        return view('admin.bazaar.index', ['bazaarData' => $bazaarData]);
    }
}
