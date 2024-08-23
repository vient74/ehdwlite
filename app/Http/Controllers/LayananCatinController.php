<?php

namespace App\Http\Controllers;

use App\Models\LayananCatin;
use Illuminate\Http\Request;

class LayananCatinController extends Controller
{
    public function index() 
    {

    }
    
    public function showLayananIndividu(string $id)
    {
        $layanans = LayananCatin::layananCatin($id);
        $manfaat  = LayananCatin::menerimaManfaat($id);       

        return view('layanan_catin.show_layanan', compact('layanans',  'manfaat'));
    }
}
