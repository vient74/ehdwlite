<?php

namespace App\Http\Controllers;

use App\Models\LayananRemajaPutri;
use Illuminate\Http\Request;

class LayananRemajaPutriController extends Controller
{
    public function index() 
    {

    }
    
    public function showLayananIndividu(string $id)
    {
        $layanans = LayananRemajaPutri::layananRemajaPutri($id);
        $manfaat  = LayananRemajaPutri::menerimaManfaat($id);       

        return view('layanan_remaja_putri.show_layanan', compact('layanans',  'manfaat'));
    }
}
