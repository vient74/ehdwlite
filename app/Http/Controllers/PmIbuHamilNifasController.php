<?php

namespace App\Http\Controllers;

use App\Models\PmIbuHamilNifas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PmIbuHamilNifasController extends Controller
{
    public function index()
    {
        $max_data = 8;
        $query = strtoupper(request('query'));
        if (request('query')) {
            $hamils = PmIbuHamilNifas::showPmIbuHamilSearch($query, $max_data);
        } else {
            $hamils = PmIbuHamilNifas::showPmIbuHamilIndex($max_data);
        }    

        $jumlahPm = DB::table('layanan.layanan_ibu_hamil_nifas')->count();

        return view('pmibu_hamil.index', compact('hamils','jumlahPm'));
    }
}
