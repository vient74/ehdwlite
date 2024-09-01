<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{

   /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $max_data = 10;
        $query = strtoupper(request('query'));

        if (request('query')) {
            $kecamatans = Kecamatan::indexKecamatanSearch($max_data, $query); 
        } else {
            $kecamatans = Kecamatan::indexKecamatan($max_data);
        }    

        if (Auth::user()->role->tag == 'admin_prov') {
            $jumlahKec = DB::table('master.master_kecamatan')->where(DB::raw('substring(master_kecamatan.id, 1, 2)'), '=', Auth::user()->provinsi_id)->count(); 
        } elseif (Auth::user()->role->tag == 'admin_kabkota') {
            $jumlahKec = DB::table('master.master_kecamatan')->where(DB::raw('substring(master_kecamatan.id, 1, 4)'), '=', Auth::user()->kabkot_id)->count();    
        } else {    
            $jumlahKec = DB::table('master.master_kecamatan')->count(); 
        }

        return view('kecamatan.index', compact('kecamatans', 'jumlahKec'));
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
       
        $id = $request->id;
        $request->validate([
            'id' => [
                'required',
                'string',
                'max:12',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_kecamatan')
                                ->where('id', '!=', $id)
                                ->where('id', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
            'kode_bps' => 'required|string|max:12',
            'name' => 'required|string|max:255',
            'long_name' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
                DB::table('master.master_kecamatan')->insert([
                    'id' => $request->id,
                    'kode_bps' => $request->kode_bps,
                    'name' => $request->name,
                    'long_name' => $request->long_name,
                    'updated_at' => now()
                ]);
                DB::commit();

                return redirect()->route('kecamatan.index')->with('message', 'Created kecamatan successfully !');

        } catch (QueryException $e) {
            DB::rollBack();
            if($e->errorInfo[0] == '23505') {
                return back()->withErrors(['id' => 'Kode Kecamatan sudah ada.'])->withInput();
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kecamatan = Kecamatan::where('id', $id)->first();
        return view('kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id' => [
                'required',
                'string',
                'max:12',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_kecamatan')
                                ->where('id', '!=', $id)
                                ->where('id', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
            'kode_bps' => 'required|string|max:12',
            'name' => 'required|string|max:255',
            'long_name' => 'required|string'
        ]);

        // cari provinsi
        $provinsi = DB::table('master.master_provinsi')
                ->where(DB::raw("left(id::text, 2)"), '=', DB::raw("left('". $request->id ."', 2)"))
                ->first();

        //dd( $provinsi->name);

        $kabupaten = DB::table('master.master_kab_kota')
                    ->where(DB::raw("left(id::text, 4)"), '=', DB::raw("left('". $request->id ."', 4)"))
                    ->first();

        // dd( $kabupaten->name);            
                
        $kecamatan = DB::table('master.master_kecamatan')
           ->where('id', $request->kode_area_lama)
           ->first();

        //dd( $request->name);

        $long_name =  'KECAMATAN ' . $request->name. ', '. $kabupaten->name . ', PROVINSI '. $provinsi->name;     

        // dd( $long_name );

        if ($kecamatan) {
            DB::beginTransaction();
            try { 
                DB::table('master.master_kecamatan')
                    ->where('id', $request->kode_area_lama)
                    ->update([
                        'id' => $request->id,
                        'kode_bps' => $request->kode_bps,
                        'name' => $request->name,
                        'long_name' => $long_name,
                        'updated_at' => now(),
                    ]);
                DB::commit();       
                return redirect()->route('kecamatan.edit', $request->id)->with('message', 'kecamatan updated successfully !');

            } catch (QueryException $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
            }
            
        }

    }


    public function listKecamatan($id)
    {
        $max_data = 10;

        $kecamatans = DB::table('master.master_kecamatan')
                ->leftJoin('master.master_desa', DB::raw('substring(master_desa.id, 1, 6)'), '=', 'master.master_kecamatan.id')
                ->leftJoin('master.master_meta_sasaran', 'master.master_meta_sasaran.desa_id', '=', 'master.master_desa.id')
                ->leftJoin('master.master_meta_kk', 'master.master_meta_kk.desa_id', '=', 'master.master_desa.id')
                ->leftJoin('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
                ->leftJoin('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id')
                ->select(
                    'master.master_kecamatan.id',
                    'master.master_kecamatan.name',
                    'master.master_kecamatan.long_name',
                    'master.master_kecamatan.updated_at',

                        DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                        DB::raw('count(distinct master.master_kpm.id) as jumlah_kpm'),
                        DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                        DB::raw('count(distinct master.master_meta_kk.kk) as jumlah_kk'),
                        DB::raw('count(distinct master.master_meta_sasaran.nik) as jumlah_sasaran')
                )
                // ->where(DB::raw('LEFT(master_kab_kota.id, 6)'), '=', $id)
                ->where(DB::raw('substring(master_kecamatan.id, 1, 4)'), '=', $id)
                ->groupBy('master.master_kecamatan.id', 'master.master_kecamatan.name', 'master.master_kecamatan.long_name')
                ->orderBy('master.master_kecamatan.id', 'ASC')
                ->cursorPaginate($max_data);

        return view('kecamatan.listkec', compact('kecamatans'));                  
    }
  
}
