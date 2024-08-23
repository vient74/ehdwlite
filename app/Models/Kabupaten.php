<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                    DB::raw('count(distinct master.master_kecamatan.id) as jumlah_kecamatan'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kab_kota.updated_at',
                )
  
                ->join('master.master_kecamatan', DB::raw("left(master.master_kecamatan.id, 4)"), '=', "master.master_kab_kota.id")
                ->join('master.master_desa', DB::raw("left(master.master_desa.id, 4)"), '=', "master.master_kab_kota.id")
                ->leftjoin('master.master_user', 'master.master_user.kabkot_id', '=', 'master.master_kab_kota.id')

                ->groupBy('master.master_kab_kota.id', 'master.master_kab_kota.name')
                ->orderBy('master.master_kab_kota.id', 'ASC')
                ->paginate($max_data);
    }

    protected function indexKabupatenSearch($max_data, $query)
    {
        return Kabupaten::select(
                'master.master_kab_kota.id',
                'master.master_kab_kota.kode_bps',
                'master.master_kab_kota.name',
                    DB::raw('count(distinct master.master_kecamatan.id) as jumlah_kecamatan'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kab_kota.updated_at',
                )
                ->join('master.master_kecamatan', DB::raw("left(master.master_kecamatan.id, 4)"), '=', "master.master_kab_kota.id")
                ->join('master.master_desa', DB::raw("left(master.master_desa.id, 4)"), '=', "master.master_kab_kota.id")
                ->leftjoin('master.master_user', 'master.master_user.kabkot_id', '=', 'master.master_kab_kota.id')

                ->where('master_kab_kota.name', 'like', '%' . $query .'%')
                ->orwhere('master_kab_kota.id', '=', '' . $query .'')
                ->groupBy('master.master_kab_kota.id', 'master.master_kab_kota.name')
                ->orderBy('master.master_kab_kota.id', 'ASC')
                ->paginate($max_data);
    }
}
