<?php

namespace App\Http\Controllers;

use App\Models\MasterSasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSasaranController extends Controller
{
    public function index() 
    {
        $max_data = 8;
        $query = strtoupper(request('query'));

        if (request('query')) {
            $sasaran = MasterSasaran::indexSasaranSearch($query, $max_data);     
        } else {
            $sasaran = MasterSasaran::indexSasaran($max_data);
        }    

        $jumlahSasaran = DB::table('master.master_meta_sasaran')->count();

        return view('mastersasaran.index', compact('sasaran', 'jumlahSasaran'));
    }

    public function inputByKpm() 
    {
        $max_data = 8;
        $query    = request('query');
        $sasaran  = MasterSasaran::indexSasaranByKpmSearch($query, $max_data);   

        $jumlahSasaran = DB::table('master.master_meta_sasaran')->where('kpm_id', $query)->count();

        return view('mastersasaran.inputbykpm', compact('sasaran', 'jumlahSasaran'));
    }

}
