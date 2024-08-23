<?php

namespace App\Http\Controllers;

use App\Models\LayananAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananAnakController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    public function showLayananIndividu(string $id)
    {
        $layanans = LayananAnak::layananAnak($id);

        $manfaat  = LayananAnak::menerimaManfaat($id);       

        return view('layanan_anak.show_layanan', compact('layanans',  'manfaat'));
    }
}
