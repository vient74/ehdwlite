<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KabupatenController extends Controller
{
    public function index() 
    {
        $max_data = 10;
        $query = strtoupper(request('query'));

        if (request('query')) {
            $kabupatens = Kabupaten::indexKabupatenSearch($max_data, $query); 
        } else {
            $kabupatens = Kabupaten::indexKabupaten($max_data);
        }    

        return view('kabupaten.index', compact('kabupatens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('kabupaten.create');
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
                    $exists = DB::table('master.master_kab_kota')
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

        DB::table('master.master_kab_kota')->insert([
            'id' => $request->id,
            'kode_bps' => $request->kode_bps,
            'name' => $request->name,
            'long_name' => $request->long_name,
            'updated_at' => now()
        ]);

        return redirect()->route('kabupaten.index')->with('message', 'Created kabupaten successfully !');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kabupaten = Kabupaten::where('id', $id)->first();
        return view('kabupaten.edit', compact('kabupaten'));
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
                    $exists = DB::table('master.master_kab_kota')
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
                ->where(DB::raw("left(id::text, 2)"), '=', DB::raw("left('". $id ."', 2)"))
                ->first();

        // dd( $provinsi->name);

        $kabupaten = DB::table('master.master_kab_kota')
                    ->where('id', $request->kode_area_lama)
                    ->first();
                
        $long_name =  $request->name. ', '. $provinsi->name;           

        if ($kabupaten) {
            DB::beginTransaction();
            try {    
                DB::table('master.master_kab_kota')
                    ->where('id', $request->kode_area_lama)
                    ->update([
                        'id' => $request->id,
                        'kode_bps' => $request->kode_bps,
                        'name' => $request->name,
                        'long_name' => $long_name,
                        'updated_at' => now(),
                    ]);
                DB::commit();    
                return redirect()->route('kabupaten.edit', $request->id)->with('message', 'Kabupaten updated successfully !');
            } catch (QueryException $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
            }
        }
    }    
}
