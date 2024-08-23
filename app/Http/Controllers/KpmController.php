<?php

namespace App\Http\Controllers;

use App\Models\Kpm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KpmController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_data = 10;
        $query = request('query');
        if (request('query')) {
            $kpms = Kpm::select('master.master_kpm.id','nik','master.master_kpm.name','username','email','nomor_telpon','desa_id', 
                                'master.master_desa.name as desa' ,'status','master_kpm.updated_at')
                    ->join('master.master_desa','master.master_desa.id','=','master.master_kpm.desa_id')
                    ->where("master.master_kpm.name", 'like', '' . $query . '%')
                    ->orWhere('master.master_kpm.username', '', '' . $query . '%')
                    ->orWhere('master.master_kpm.email', '=', '' . $query . '')
                    ->orWhere('master.master_kpm.username', 'like', '%' . $query . '%')     
                    ->orWhere('master.master_desa.id', '=', '' . $query . '')                     
                    ->cursorPaginate($max_data)
                    ->withQueryString();
                    
        } else {
            $kpms = Kpm::select('master.master_kpm.id','nik','master.master_kpm.name','username','email','nomor_telpon','desa_id', 
                                'master.master_desa.name as desa' ,'status','master_kpm.updated_at')
                    ->join('master.master_desa','master.master_desa.id','=','master.master_kpm.desa_id')
                    ->orderBy('master.master_kpm.id', 'ASC')
                    ->cursorPaginate($max_data);  
        }    

        $lastid = Kpm::orderBy('id', 'DESC') 
            ->limit(5)  
            ->get();

        $jumlahkpm = DB::table('master.master_kpm')->count();
        return view('kpm.index', compact('kpms', 'lastid', 'jumlahkpm'));
    }
    

    public function edit($id)
    {
       $kpm = Kpm::where('id', $id)->first();
       // input KK
       $countKk = DB::table('master.master_meta_kk')
                ->where('kpm_id', $kpm->id)
                ->count();

       // input Sasaran
        $countSs = DB::table('master.master_meta_sasaran')
                    ->where('kpm_id', $kpm->id)
                    ->count();

       return view('kpm.edit', compact('kpm', 'countKk', 'countSs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'nik' => [
            'required',
            'max:17',
            function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('master.master_kpm')
                            ->where('id', '!=', $id)
                            ->where('nik', '=', $value)
                            ->exists();

                if ($exists) {
                    $fail('The ' . $attribute . ' has already been taken.');
                }
            },
        ],

        'username' => [
            'required',
            'string',
            function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('master.master_kpm')
                            ->where('id', '!=', $id)
                            ->where('username', '=', $value)
                            ->exists();

                if ($exists) {
                    $fail('The ' . $attribute . ' has already been taken.');
                }
            },
        ],

        'name' => 'required|string|max:255',

        'email' => [
            'required',
            'string',
            'max:150',
            function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('master.master_kpm')
                            ->where('id', '!=', $id)
                            ->where('email', '=', $value)
                            ->exists();

                if ($exists) {
                    $fail('The ' . $attribute . ' has already been taken.');
                }
            },
        ],
        'desa_id' => 'required'
    ]);

    $kpm_data = DB::table('master.master_kpm')
       ->where('id', $id)
       ->first();

    if ($kpm_data) {
        try {
            DB::table('master.master_kpm')
                ->where('id', $id)
                ->update([
                    'desa_id' => $request->desa_id,
                    'nik' => $request->nik,
                    'status' => $request->status,
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                    'nomor_telpon' => $request->nomor_telpon,
                    'updated_at' => now(),
                ]);

            return redirect()->route('kpm.edit', $id)->with('message', 'KPM updated successfully!');
        } catch (QueryException $e) {
            // Cek kode error untuk duplikasi
            if ($e->errorInfo[0] == '23505') {
                $errorField = $e->errorInfo[1]; // Kode field yang gagal uniknya
                switch ($errorField) {
                    case 'nik':
                        return back()->withErrors(['nik' => 'NIK sudah ada.'])->withInput();
                    case 'email':
                        return back()->withErrors(['email' => 'Email sudah ada.'])->withInput();
                    case 'username':
                        return back()->withErrors(['username' => 'Username sudah ada.'])->withInput();
                    default:
                        return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
                }
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    } else {
        return redirect()->back()->with('error', 'KPM dengan ID tersebut tidak ditemukan.');
    }
}


}
