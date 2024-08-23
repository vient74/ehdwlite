<?php

namespace App\Http\Controllers;

use App\Models\MasterKk;
use Illuminate\Support\Facades\DB;

class MasterKkController extends Controller
{
    public function index() 
    {
        $max_data = 10;
        $query = strtoupper(request('query'));

        if (request('query')) {
            $kks = MasterKk::indexMasterKkSearch($max_data,$query); 
        } else {
            $kks = MasterKk::indexMasterKk($max_data); 
        }    
        
        $jumlahKk = DB::table('master.master_meta_kk')->count();

        return view('masterkk.index', compact('kks','jumlahKk'));
    }

    public function inputByKpm() 
    {
        $max_data= 8;
        $query   = request('query');
        $kks     = MasterKk::indexKkByKpmSearch($query, $max_data);   

        $jumlahKk = DB::table('master.master_meta_kk')->where('kpm_id', $query)->count();

        return view('masterkk.inputbykpm', compact('kks', 'jumlahKk'));
    }

}
