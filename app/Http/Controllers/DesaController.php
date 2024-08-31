<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\MasterKk;
use App\Models\MasterSasaran;
use App\Models\Provinsi;
use App\Models\ScoreDesa2023;
use App\Models\ScoreDesa2024;
use App\Models\ScoreDesaValidate2023;
use App\Models\ScoreDesaValidate2024;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_data = 20;
        $query = strtoupper(request('query'));
        if (request('query')) {
            $desas = Desa::indexDesaSearch($query, $max_data);
        } else {
            $desas = Desa::indexDesa($max_data);
        }  

        if (Auth::user()->role->tag == 'admin_prov') {
            $jumlahDesa = DB::table('master.master_desa')->where(DB::raw('substring(master_desa.id, 1, 2)'), '=', Auth::user()->provinsi_id)->count(); 
        } elseif (Auth::user()->role->tag == 'admin_kabkota') {
            $jumlahDesa = DB::table('master.master_desa')->where(DB::raw('substring(master_desa.id, 1, 4)'), '=', Auth::user()->kabkot_id)->count();    
        } else {    
            $jumlahDesa = DB::table('master.master_desa')->count(); 
        }
 
        return view('desa.index', compact('desas','jumlahDesa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('desa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'id' => [
                'required',
                'string',
                'max:12',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_desa')
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

        $kabupaten = DB::table('master.master_kab_kota')
                    ->where(DB::raw("left(id::text, 4)"), '=', DB::raw("left('". $request->id ."', 4)"))
                    ->first();
 
        $kecamatan = DB::table('master.master_kecamatan')
           ->where(DB::raw("left(id::text, 6)"), '=', DB::raw("left('". $request->id ."', 6)"))
           ->first();
   
        $long_name =  $request->name . ', KECAMATAN ' . $kecamatan->name. ', '. $kabupaten->name . ', PROVINSI '. $provinsi->name;    

        DB::beginTransaction();
        try {
            DB::table('master.master_desa')->insert([
                'id' => $request->id,
                'kode_bps' => $request->kode_bps,
                'name' => $request->name,
                'long_name' => $long_name,
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->route('desa.index')->with('message', 'created desa successfully !');

        } catch (QueryException $e) {
            DB::rollBack();
            if($e->errorInfo[0] == '23505') {
                return back()->withErrors(['id' => 'Kode Desa sudah ada.'])->withInput();
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $desa = Desa::where('id', $id)->first();
        // cek kode wilayah
        $desa_id = $desa->id;
        $provinsi_id  = substr($desa_id, 0, 2);
        $kabkot_id    = substr($desa_id, 0, 4);
        $kecamatan_id = substr($desa_id, 0, 6);

        $prov = Provinsi::select('id','name as provinsi')->where('id', $provinsi_id)->first();
        $kab  = Kabupaten::select('id','name as kabupaten')->where('id', $kabkot_id)->first();
        $kec  = Kecamatan::select('id','name as kecamatan')->where('id', $kecamatan_id)->first();

        return view('desa.edit', compact('desa','prov','kab','kec'));
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
                    $exists = DB::table('master.master_desa')
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

        $kabupaten = DB::table('master.master_kab_kota')
                    ->where(DB::raw("left(id::text, 4)"), '=', DB::raw("left('". $request->id ."', 4)"))
                    ->first();
 
        $kecamatan = DB::table('master.master_kecamatan')
           ->where(DB::raw("left(id::text, 6)"), '=', DB::raw("left('". $request->id ."', 6)"))
           ->first();

        $desa = DB::table('master.master_desa')
           ->where('id', $request->kode_desa_lama)
           ->first();

        $long_name =  $desa->name . ', KECAMATAN ' . $kecamatan->name. ', '. $kabupaten->name . ', PROVINSI '. $provinsi->name;    
    
        if ($desa) {
            DB::beginTransaction();
            try {
                DB::table('master.master_desa')
                    ->where('id', $request->kode_desa_lama)
                    ->update([
                        'id' => $request->id,
                        'kode_bps' => $request->kode_bps,
                        'name' => $request->name,
                        'long_name' => $long_name,
                        'updated_at' => now(),
                    ]);
                DB::commit();
    
                return redirect()->route('desa.edit',  $request->id)->with('message', 'Desa updated successfully !');

            } catch (QueryException $e) {
                DB::rollBack();
                if($e->errorInfo[0] == '23505') {
                    return back()->withErrors(['id' => 'Kode Desa sudah ada.'])->withInput();
                }
                return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
            }        

        } else {
            return redirect()->back()->with('error', 'Desa dengan kode tersebut tidak ditemukan.');
        }
    }

    public function autodesa()
    {
        $query = strtoupper(request('q'));
        $data = Desa::select('id', 'long_name')
                    ->where('name', 'LIKE', "$query%")
                    ->limit(50)  
                    ->get();

        return response()->json([
            'results' => $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->long_name
                ];
            }),
            'pagination' => [
                'more' => false  
            ]
        ]);
    }

    protected function getJumlahKK(string $id) {
        return DB::table('master.master_meta_kk')
                ->where('desa_id', $id)  
                ->count();

    }

    public function showkk(string $id)
    {
        $max_data = 10;
        $query = trim(request('query'));
        if (request('query')) {
            $desas = MasterKk::showMetaKkSearch($query, $max_data);
        } else {
            $desas = MasterKk::showMetaKk($id, $max_data);  
        }    

        $jumlahKk = $this->getJumlahKK($id);

        return view('desa.showkk', compact('desas', 'id', 'jumlahKk'));
    }

    public function showsasaran(string $id)
    {
        $max_data = 8;
        $query = trim(request('query'));
        if (request('query')) {
            $desas = MasterSasaran::showSasaranSearch($query, $max_data); 

        } else {
            $desas = MasterSasaran::showMetaSasaran($id, $max_data);
        }    
        // total kk
        $jumlahNik = DB::table('master.master_meta_sasaran')
                    ->where('desa_id', $id)  
                    ->count();
    
        return view('desa.showsasaran', compact('desas', 'id', 'jumlahNik'));
    }

    public function listDesa($id)
    {
        $max_data = 100;

        $desas = DB::table('master.master_desa')
                ->leftJoin('master.master_meta_kk', 'master.master_desa.id', '=', 'master.master_meta_kk.desa_id')
                ->leftJoin('master.master_meta_sasaran', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                ->leftJoin('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
                ->leftJoin('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id')
                ->select(
                    'master.master_desa.id',
                    'master.master_desa.name',
                    'master.master_desa.long_name',
                    'master.master_desa.updated_at',
                        DB::raw('count(distinct master.master_kpm.id) as jumlah_kpm'),
                        DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                        DB::raw('count(distinct master.master_meta_kk.kk) as jumlah_kk'),
                        DB::raw('count(distinct master.master_meta_sasaran.nik) as jumlah_sasaran')
                )
                // ->where(DB::raw('LEFT(master_desa.id, 6)'), '=', $id)
                ->where(DB::raw('substring(master_desa.id, 1, 6)'), '=', $id)
                ->groupBy('master.master_desa.id', 'master.master_desa.name', 'master.master_desa.long_name')
                ->orderBy('master.master_desa.id', 'ASC')
                ->cursorPaginate($max_data);

        return view('desa.listdesa', compact('desas'));                  
    }

    // public function rekapDataDesa()
    // {
    //     // Validasi request yang masuk
    //     $validatedData = request()->validate([
    //         'desa_id' => 'required',
    //         'tahun'   => 'required',
    //         'tw'      => 'required',
    //     ]);

    //     // Jika validasi lolos, gunakan data yang telah divalidasi
    //     $id    = $validatedData['desa_id'];
    //     $tahun = $validatedData['tahun'];
    //     $tw    = $validatedData['tw'];
    
    //     $desa  = Desa::where('id', $id)->first();
    //     $score = ScoreDesa2023::where('meta_kode_desa', $id)
    //             ->where('meta_tahun', $tahun)
    //             ->where('meta_tw', $tw)
    //             ->first();

    //     return view('desa.rekap_data_desa', compact('desa','score'));
    // }

    public function rekapDataDesaForm()
    {

        $id    = request('desa_id');
        $tahun = request('tahun');
        $tw    = request('tw');
       
        $desa  = Desa::where('id', $id)->first();
  
        return view('desa.rekap_data_desa_form', compact('desa'));    

    }

    public function rekapDataDesa(Request $request)
    {
        $id         = $request->desa_id;
        $tahun      = $request->tahun;
        $tw         = $request->tw;
        $kategori   = $request->kategori;
       
        $desa  = Desa::where('id', $id)->first();
        if ($tahun == '2023') {
            if ($kategori == 1) { // belum validasi
                $score = ScoreDesa2023::where('meta_kode_desa', $id)
                        ->where('meta_tahun', $tahun)
                        ->where('meta_tw', $tw)
                        ->first();
            } else {
                $score = ScoreDesaValidate2023::where('meta_kode_desa', $id)
                        ->where('meta_tahun', $tahun)
                        ->where('meta_tw', $tw)
                        ->first();
            }    
        } elseif ($tahun == '2024') {
            if ($kategori == 1) { // belum validasi
                $score = ScoreDesa2024::where('meta_kode_desa', $id)
                        ->where('meta_tahun', $tahun)
                        ->where('meta_tw', $tw)
                        ->first();
            } else {
                $score = ScoreDesaValidate2024::where('meta_kode_desa', $id)
                        ->where('meta_tahun', $tahun)
                        ->where('meta_tw', $tw)
                        ->first();
            }            
        }            
        return view('desa.rekap_data_desa', compact('desa', 'score'));    
    }

}
