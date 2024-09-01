<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Kabupaten extends Model
{
   use HasFactory;
    
    protected $table  = 'master_kab_kota';
    protected $primaryKey  = 'id';

    protected static function booted()
    {
        $schema = 'master';  
        static::addGlobalScope(new SchemaScope($schema));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'kode_bps',
        'name',
        'long_name' 
    ];

     /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }


 
    protected function indexKabupaten($max_data)
    {
        $sql = Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                'master.master_kab_kota.updated_at',
                 DB::raw('count(distinct master.master_kecamatan.id)  as jumlah_kecamatan'),
                 DB::raw('count(distinct master.master_kpm.id)  as jumlah_kpm'),
                 DB::raw('count(distinct master.master_user.id) as jumlah_user'),
        );

        $sql->leftJoin('master.master_desa', DB::raw('substring(master_desa.id, 1, 4)'), '=', 'master.master_kab_kota.id')
            ->leftJoin('master.master_kecamatan', DB::raw('substring(master_desa.id, 1, 6)'), '=', 'master.master_kecamatan.id')
            ->leftJoin('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
            ->leftJoin('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id');

        if (Auth::user()->role->tag == 'admin_prov') {
             $sql->where(DB::raw("left(master_kab_kota.id, 2)"), '=', Auth::user()->provinsi_id);
        }

        $data =  $sql->groupBy('master_kab_kota.id', 'master.master_kab_kota.name')
                     ->orderBy('master.master_kab_kota.id', 'ASC')
                     ->paginate($max_data);

        return $data;            
    }

    protected function indexKabupatenSearch($max_data, $query)
    {
       $sql = Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                'master.master_kab_kota.updated_at',
                 DB::raw('count(distinct master.master_kecamatan.id)  as jumlah_kecamatan'),
                 DB::raw('count(distinct master.master_kpm.id)  as jumlah_kpm'),
                 DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                 );

                $sql->leftJoin('master.master_desa', DB::raw('substring(master_desa.id, 1, 4)'), '=', 'master.master_kab_kota.id')
                    ->leftJoin('master.master_kecamatan', DB::raw('substring(master_desa.id, 1, 6)'), '=', 'master.master_kecamatan.id')
                    ->leftJoin('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
                    ->leftJoin('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id');

           
                if (Auth::user()->role->tag == 'admin_prov') {
                    $sql->where(DB::raw("left(master_kab_kota.id, 2)"), '=', Auth::user()->provinsi_id);
                }
 
                $data =  $sql->where('master_kab_kota.name', 'like', '%' . $query .'%') 
                             ->where('master_kab_kota.long_name', 'like', '%' . $query .'%')
                             ->orWhere('master_kab_kota.id', '=', '' . $query .'') 
                             ->groupBy('master.master_kab_kota.id', 'master.master_kab_kota.name')
                             ->orderBy('master.master_kab_kota.id', 'ASC')
                             ->paginate($max_data)
                             ->withQueryString();

        return $data;             
    }



    protected function monitoringKabupatenSearch($max_data, $query)
    {
       $sql = Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                    DB::raw('count(distinct master.master_kecamatan.id) as jumlah_kecamatan'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kab_kota.updated_at',
                )
                ->leftJoin('master.master_kecamatan', DB::raw("left(master.master_kecamatan.id, 4)"), '=', "master.master_kab_kota.id")
                ->leftJoin('master.master_desa', DB::raw("left(master.master_desa.id, 4)"), '=', "master.master_kab_kota.id")
                ->leftjoin('master.master_user', 'master.master_user.kabkot_id', '=', 'master.master_kab_kota.id');

                if (Auth::user()->role->tag == 'admin_prov') {
                    $sql->where('master.master_provinsi.id', '=', Auth::user()->provinsi_id);
                }

                $data =  $sql->where('master_kab_kota.name', 'like', '%' . $query .'%')
                             ->orwhere('master_kab_kota.id', '=', '' . $query .'')
                             ->groupBy('master.master_kab_kota.id', 'master.master_kab_kota.name')
                             ->orderBy('master.master_kab_kota.id', 'ASC')
                             ->paginate($max_data);
        return $data;             
    }



    protected function monitoringKabupaten($max_data)
    {
        $sql = Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                DB::raw('count(distinct master.master_kecamatan.id) as jumlah_kecamatan'),
                DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kab_kota.updated_at'
            )
            ->leftJoin('master.master_kecamatan', DB::raw('substring(master.master_kecamatan.id, 1, 4)'), '=', 'master.master_kab_kota.id')
            ->leftJoin('master.master_desa', DB::raw('substring(master.master_desa.id, 1, 4)'), '=', 'master.master_kab_kota.id')
            ->leftJoin('master.master_user', 'master.master_user.kabkot_id', '=', 'master.master_kab_kota.id');
        //     ->leftJoin('master.master_provinsi', 'master.master_provinsi.id', '=', DB::raw('substring(master.master_kab_kota.id, 1, 2)')); // Pastikan ada kolom 'provinsi_id' di master_kab_kota

        // if (Auth::user()->role->tag == 'admin_prov') {
        //     $sql->where('master.master_provinsi.id', '=', Auth::user()->provinsi_id);
        // }

         $sql->groupBy('master.master_kab_kota.id', 'master.master_kab_kota.name')
                    ->orderBy('master.master_kab_kota.id', 'ASC')
                    ->paginate($max_data);

        return $sql;            
    }
}
