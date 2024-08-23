<?php

namespace App\Http\Controllers;

use App\Models\PmAnak;
use App\Models\PmCatin;
use Illuminate\Support\Facades\DB;

class PmCatinController extends Controller
{
    public function index()
    {
        $max_data = 8;
        $query = strtoupper(request('query'));
        if (request('query')) {
            $catins = PmCatin::showPmCatinSearch($query, $max_data);
        } else {
            $catins = PmCatin::showPmCatinIndex($max_data);
        }    

        $jumlahPm = DB::table('layanan.layanan_catin')->count();

        return view('pmcatin.index', compact('catins','jumlahPm'));
    }
}
