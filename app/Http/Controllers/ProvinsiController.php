<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $max_data = 10;
        $query = request('query');
        if (request('query')) {
            $provincies = Provinsi::indexProvinsiSearch($max_data, $query); 
        } else {
            $provincies = Provinsi::indexProvinsi($max_data); 
        }    

        return view('provinsi.index', compact('provincies'));
    }

    public function create()
    {
        return view('provinsi.create');
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
                'max:2',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_provinsi')
                                ->where('id', '!=', $id)
                                ->where('id', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
            'kode_bps' => 'required|string|max:2',
            'name' => 'required|string|max:255',
        ]);

        DB::table('master.master_provinsi')->insert([
            'id' => $request->id,
            'kode_bps' => $request->kode_bps,
            'name' => $request->name
        ]);

        return redirect()->route('provinsi.index')->with('message', 'created data successfully !');
       
    }



     /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $provinsi = Provinsi::where('id', $id)->first();
        return view('provinsi.edit', compact('provinsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => [
                'required',
                'string',
                'max:2',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_provinsi')
                                ->where('id', '!=', $id)
                                ->where('id', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
            'kode_bps' => 'required|string|max:2',
            'name' => 'required|string|max:255',
        ]);

        $provinsi = Provinsi::findOrFail($id);
 
        if (!$provinsi) {
            abort(404);  
        }

        DB::table('master.master_provinsi')
        ->where('id', $id)
        ->update($request->only(['kode_bps', 'name']));

        return redirect()->route('provinsi.edit', $id)->with('message', 'Provinsi updated successfully !');
    }


}
