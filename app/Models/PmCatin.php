<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PmCatin extends Model
{
   use HasFactory;
    
    protected $table  = 'pm_catin';
    protected $primaryKey  = 'id';

    protected static function booted()
    {
        $schema = 'layanan';  
        static::addGlobalScope(new SchemaScope($schema));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'is_active',
        'activated_at',
        'last_eval',
        'sasaran_id',
        'desa_id',
        'dusun_id',
        'kpm_id',
        'last_calculate',
        'task_ava',
        'task_val' 
    ];

     /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected function showPmCatinIndex($max_data)
    {
        $remajas = DB::table('layanan.pm_catin')

                    ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_catin.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_catin.kpm_id')
                    ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=',  DB::raw("left(layanan.pm_catin.id, 16)"))

                    ->select('master.master_meta_sasaran.kk','layanan.pm_catin.id', 'master.master_meta_sasaran.nik', 'nama', 'master.master_meta_sasaran.desa_id', 
                             'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                              DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),  
                             'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
                             'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm',
                             'pm_catin.is_active','pm_catin.actived_at','pm_catin.last_eval',
                             'pm_catin.sasaran_id','last_calculate','task_ava','task_val')

                    ->orderBy('layanan.pm_catin.id', 'ASC')
                    ->cursorPaginate($max_data);

        return $remajas;            
    }     

    protected function showPmCatinIndexSearch($query, $max_data)
    {
        $remajas = DB::table('layanan.pm_catin')

                    ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_catin.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_catin.kpm_id')
                    ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=',  DB::raw("left(layanan.pm_catin.id, 16)"))

                    ->select('master.master_meta_sasaran.kk','layanan.pm_catin.id', 'master.master_meta_sasaran.nik', 'nama', 'master.master_meta_sasaran.desa_id', 
                             'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                              DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),  
                             'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
                             'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm',
                             'pm_catin.is_active','pm_catin.actived_at','pm_catin.last_eval',
                             'pm_catin.sasaran_id','last_calculate','task_ava','task_val')

                
                    ->where('master.master_meta_sasaran.kk',  $query)
                    ->orWhere('master.master_meta_sasaran.nik', $query)
                    ->orWhere('master.master_meta_sasaran.nama', 'LIKE',  $query . '%')
                    ->orderBy('layanan.pm_catin.id', 'ASC')
                    ->cursorPaginate($max_data)
                    ->withQueryString();

        return $remajas;            
    }     






    // protected function showPmCatinIndexSearch($max_data, $query)
    // {
    //     $remajas = DB::table('layanan.pm_catin')

    //                 ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_catin.desa_id')
    //                 ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_catin.kpm_id')
    //                 ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=',  DB::raw("left(layanan.pm_catin.id, 16)"))

    //                 ->select('master.master_meta_sasaran.kk','layanan.pm_catin.id', 'master.master_meta_sasaran.nik', 'nama', 'master.master_meta_sasaran.desa_id', 
    //                          'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
    //                           DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),  
    //                          'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
    //                          'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm',
    //                          'pm_catin.is_active','pm_catin.actived_at','pm_catin.last_eval',
    //                          'pm_catin.sasaran_id','last_calculate','task_ava','task_val')

    //                 ->where('master.master_meta_sasaran.kk',  $query)
    //                 ->orWhere('master.master_meta_sasaran.nik', $query)
    //                 ->orWhere('nama', 'like', '%' . $query . '%')
    //                 ->orderBy('layanan.pm_catin.id', 'ASC')
    //                 ->cursorPaginate($max_data)
    //                 ->withQueryString();         

    //     return $remajas;            
    // }     


    // protected function showPmCatinIndexSearch($max_data, $query)
    // {
    //     // Base query
    //     $sql = PmCatin::query()
    //         ->select(
    //             'master.master_meta_sasaran.kk',
    //             'layanan.pm_catin.id',
    //             'master.master_meta_sasaran.nik',
    //             'nama',
    //             'master.master_meta_sasaran.desa_id',
    //             'master.master_desa.name as desa',
    //             'master.master_meta_sasaran.tgl_lahir',
    //             DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),
    //             'master.master_meta_sasaran.jenis_kelamin',
    //             'status_keluarga',
    //             'master.master_meta_sasaran.updated_at',
    //             'master.master_kpm.name as nama_kpm',
    //             'pm_catin.is_active',
    //             'pm_catin.actived_at',
    //             'pm_catin.last_eval',
    //             'pm_catin.sasaran_id',
    //             'last_calculate',
    //             'task_ava',
    //             'task_val'
    //         )
    //         ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_catin.desa_id')
    //         ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_catin.kpm_id')
    //         ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=', DB::raw("LEFT(layanan.pm_catin.id::TEXT, 16)"));

    //     // Apply role-based filter
    //     if (Auth::user()->role->tag == 'admin_prov') {
    //         $sql->where(DB::raw("LEFT(layanan.pm_catin.id::TEXT, 2)"), '=', Auth::user()->provinsi_id);
    //     }

    //       $data = $sql->where('master.master_meta_sasaran.kk', $query)
    //                     ->orWhere('master.master_meta_sasaran.nik', $query)
    //                     ->orWhere('nama', 'like', '%' . $query . '%')
    //                     ->orderBy('layanan.pm_catin.id', 'ASC')
    //                     ->cursorPaginate($max_data)
    //                     ->withQueryString();

    //     return $data;
    // }




}    
