<?php

namespace App\Http\Controllers;

use App\Models\PmAnak;
use Illuminate\Support\Facades\DB;

class PmAnakController extends Controller
{

    public function index()
    {
        $max_data = 8;
        $query = strtoupper(request('query'));
        if (request('query')) {
            $anaks = PmAnak::showPmAnakSearch($query, $max_data);
        } else {
            $anaks = PmAnak::showPmAnakIndex($max_data);
        }    

        $jumlahPm = DB::table('layanan.layanan_anak')->count();

        return view('pmanak.index', compact('anaks','jumlahPm'));
    }


}
