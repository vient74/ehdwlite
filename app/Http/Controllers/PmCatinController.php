<?php

namespace App\Http\Controllers;

use App\Models\PmAnak;
use App\Models\PmCatin;
use Illuminate\Support\Facades\DB;

class PmCatinController extends Controller
{
    public function index()
    {
        $max_data = 10;
        $query = request('query');

        if (request('query')) {
            $catins = PmCatin::showPmCatinIndexSearch($query, $max_data);
        } else {
            $catins = PmCatin::showPmCatinIndex($max_data);
        }    

        //$jumlahPm = DB::table('layanan.layanan_catin')->count();
        $jumlahPm = 1000;
        return view('pmcatin.index', compact('catins','jumlahPm'));
    }
}
