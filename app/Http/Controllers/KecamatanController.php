<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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
        return view('kecamatan.index', compact('kecamatans'));
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


         $kecamatan = DB::table('master.master_kecamatan')
           ->where('id', $request->kode_area_lama)
           ->first();

        if ($kecamatan) {
            DB::table('master.master_kecamatan')
                ->where('id', $request->kode_area_lama)
                ->update([
                    'id' => $request->id,
                    'kode_bps' => $request->kode_bps,
                    'name' => $request->name,
                    'long_name' => $request->long_name,
                    'updated_at' => now(),
                ]);

        return redirect()->route('kecamatan.edit', $request->id)->with('message', 'kecamatan updated successfully !');
        }

    }
  
}
