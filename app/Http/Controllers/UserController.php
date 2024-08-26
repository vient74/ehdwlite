<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

 
class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_data = 10;
        $query = request('query');

        if ($query) {
            $usersQuery = User::select('*');
            if (Auth::user()->role->tag == 'admin_prov') {
                $usersQuery->where('master.master_user.provinsi_id', '=', Auth::user()->provinsi_id);
            } elseif (Auth::user()->role->tag == 'admin_kabkota') {
                $usersQuery->where('master.master_user.kabkot_id', '=', Auth::user()->kabkot_id);
            }
            $users = $usersQuery->where(DB::raw('UPPER(name)'), 'like', '%' . strtoupper($query) . '%')
                                ->orWhere('username', 'like', '%' . $query . '%')
                                ->orWhere('kabkot_id', '=', $query)
                                ->orWhere('kecamatan_id', '=', $query)
                                ->orWhere('desa_id', '=', $query)
                                ->orderBy('id', 'ASC')
                                ->cursorPaginate($max_data);
        } else {
            $usersQuery = User::select('*');
            if (Auth::user()->role->tag == 'admin_prov') {
                $usersQuery->where('master.master_user.provinsi_id', '=', Auth::user()->provinsi_id);
            } elseif (Auth::user()->role->tag == 'admin_kabkota') {
                $usersQuery->where('master.master_user.kabkot_id', '=', Auth::user()->kabkot_id);
            }
            $users = $usersQuery->orderBy('id', 'ASC')->cursorPaginate($max_data);
        }

        $usersQueryJml = User::select('*');
        if (Auth::user()->role->tag == 'admin_prov') {
            $usersQueryJml->where('master.master_user.provinsi_id', '=', Auth::user()->provinsi_id);
        } elseif (Auth::user()->role->tag == 'admin_kabkota') {
            $usersQueryJml->where('master.master_user.kabkot_id', '=', Auth::user()->kabkot_id);
        }       
        $lastid = $usersQueryJml->orderBy('id', 'DESC')->limit(5)->get();

        $usersQueryJmlLast = DB::table('master.master_user');
        if (Auth::user()->role->tag == 'admin_prov') {
            $usersQueryJmlLast->where('master.master_user.provinsi_id', '=', Auth::user()->provinsi_id);
        } elseif (Auth::user()->role->tag == 'admin_kabkota') {
            $usersQueryJmlLast->where('master.master_user.kabkot_id', '=', Auth::user()->kabkot_id);
        }    
        $jumlahuser = $usersQueryJmlLast->count();

        return view('user.index', compact('users', 'lastid', 'jumlahuser'));
    }

  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $roles = Role::select('id as kode', 'name')->get();  
       
       return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    { 
        // dd($request->all());
        $id = $request->username;
   
        $role_id  = $request->input('role_id');
        $desa_id  = $request->input('desa_id');

        $provinsi_id  = substr($desa_id, 0, 2);
        $kabkot_id    = substr($desa_id, 0, 4);
        $kecamatan_id = substr($desa_id, 0, 6);

        if ($role_id == '129b44eb-d7ab-4023-9f21-3858cc733b28') { // admin_desa
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = $desa_id;
        }  elseif ($role_id == '6dacde63-69b7-4d54-8816-693b8c188438') { // kpm
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = $desa_id;
        } elseif ($role_id == '3ac13019-aa8b-4c41-9c8e-c0c90cb6bbc0') { // admin prov
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = '';
            $kecamatan_id = '';
            $desa_id      = '';
        } elseif ($role_id == 'fa3f2ff4-46d1-4fe9-a7bb-f28fe6cd8b69') { // admin kabupaten
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = '';
            $desa_id      = '';
        } elseif ($role_id == '988a397a-9711-4a82-b344-e7c5601126c7') { // admin kecamatan
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = '';
        }

        $request->validate([
            'role_id' => 'required',
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_user')
                                ->where('username', '!=', $id)
                                ->where('username', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
            'email' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = DB::table('master.master_user')
                                ->where('email', '!=', $id)
                                ->where('email', '=', $value)
                                ->exists();

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],
        ]);

        try {
            //dd($request->input('role_id'));
            DB::table('master.master_user')->insert([
                'role_id' => $role_id,
                'provinsi_id' => $provinsi_id,
                'kabkot_id'   => $kabkot_id,
                'kecamatan_id' => $kecamatan_id,
                'desa_id' => $desa_id,
                'status' => 1,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),  
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('user.index')->with('message', 'Created user successfully!');

        } catch (QueryException $e) {
            // Cek kode error untuk duplikasi
            if($e->errorInfo[0] == '23505') {
                return back()->withErrors(['username' => 'Username sudah ada.'])->withInput();
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }


    public function edit($id)
    {
       $user  = User::where('id', $id)->first();
       $roles = Role::select('id as kode', 'name')->get();  
       return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $role_id  = $request->input('role_id');
        $desa_id  = $request->input('desa_id');

        $provinsi_id  = substr($desa_id, 0, 2);
        $kabkot_id    = substr($desa_id, 0, 4);
        $kecamatan_id = substr($desa_id, 0, 6);

        if ($role_id == '129b44eb-d7ab-4023-9f21-3858cc733b28') { // admin_desa
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = $desa_id;
        }  elseif ($role_id == '6dacde63-69b7-4d54-8816-693b8c188438') { // kpm
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = $desa_id;
        } elseif ($role_id == '3ac13019-aa8b-4c41-9c8e-c0c90cb6bbc0') { // admin prov
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = '';
            $kecamatan_id = '';
            $desa_id      = '';
        } elseif ($role_id == 'fa3f2ff4-46d1-4fe9-a7bb-f28fe6cd8b69') { // admin kabupaten
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = '';
            $desa_id      = '';
        } elseif ($role_id == '988a397a-9711-4a82-b344-e7c5601126c7') { // admin kecamatan
            $provinsi_id  = $provinsi_id;
            $kabkot_id    = $kabkot_id;
            $kecamatan_id = $kecamatan_id;
            $desa_id      = '';
        }

        $user_check = User::findOrFail($id);
 
        if (!$user_check) {
            abort(404);  
        }

        $password_hidden = $request->input('password_hidden');
        if (!empty($password)) {
            $password = $password_hidden;
        } else {
            $password = $request->input('password');
        }

        $dataToUpdate = $request->only([
            'role_id', 
            'provinsi_id',
            'kabkot_id',
            'kecamatan_id',
            'desa_id',
            'status', 
            'name',
            'username',
            'email'
        ]);
      
        try {
            DB::table('master.master_user')
                ->where('id', $id)
                ->update(array_merge(
                    $dataToUpdate,
                    ['updated_at' => now()]
                    ));
        } catch (QueryException $e) {
            // Log the error
            Log::error('Update failed:', ['error' => $e->getMessage()]);

            // Redirect back with an error message
            return redirect()->back()->withInput()->withErrors([
                'username' => 'The username has already been taken.',
                'email' => 'The email has already been taken.',
            ]);
        }

        return redirect()->route('user.edit', $id)->with('message', 'User updated successfully !');
    }

    public function editpassword($id)
    {
       $user = User::where('id', $id)->first();
       return view('user.editpassword', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

    
        User::where('id', $id)->update([
            'password' =>  Hash::make($request->password),  
        ]);

        return redirect()->route('user.index')->with('message', 'Password updated successfully!');
    }

}
