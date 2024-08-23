<?php

namespace App\Http\Controllers;

use App\Models\PmRemajaPutri;
use Illuminate\Support\Facades\DB;

class PmRemajaPutriController extends Controller
{
    public function index()
    {
        $max_data = 8;
        $query = strtoupper(request('query'));
        if (request('query')) {
            $remajas = PmRemajaPutri::showPmRemajaPutriSearch($query, $max_data);
        } else {
            $remajas = PmRemajaPutri::showPmRemajaPutriIndex($max_data);
        }    

        $jumlahPm = DB::table('layanan.layanan_remaja_putri')->count();

        return view('pmremaja_putri.index', compact('remajas','jumlahPm'));
    }
}
