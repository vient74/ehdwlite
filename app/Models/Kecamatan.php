<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kecamatan extends Model
{
   use HasFactory;
    
    protected $table  = 'master_kecamatan';
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

    protected function indexKecamatan($max_data)
    {
        return Kecamatan::select(
                'master.master_kecamatan.id',
                'master.master_kecamatan.kode_bps',
                'master.master_kecamatan.name',
                'master.master_kecamatan.long_name',
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kecamatan.updated_at',
                )
                ->join('master.master_desa', DB::raw('substring(master.master_desa.id, 1, 6)'), '=', DB::raw('substring(master.master_kecamatan.id, 1, 6)'))
                ->leftjoin('master.master_user', 'master.master_user.kecamatan_id', '=', 'master.master_kecamatan.id')

                
                ->groupBy('master.master_kecamatan.id', 'master.master_kecamatan.name')
                ->orderBy('master.master_kecamatan.id', 'ASC')
                ->paginate($max_data);

        return  $kecamatan;

    }

    protected function indexKecamatanSearch($max_data, $query)
    {
        return Kecamatan::select(
                'master.master_kecamatan.id',
                'master.master_kecamatan.kode_bps',
                'master.master_kecamatan.name',
                'master.master_kecamatan.long_name',
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kecamatan.updated_at',
                )
                ->join('master.master_desa', DB::raw('substring(master.master_desa.id, 1, 6)'), '=', DB::raw('substring(master.master_kecamatan.id, 1, 6)'))
                ->leftjoin('master.master_user', 'master.master_user.kecamatan_id', '=', 'master.master_kecamatan.id')
                ->where('master_kecamatan.name', 'like', '%' . $query .'%')
                ->orwhere('master_kecamatan.id', '=', '' . $query .'')
                ->groupBy('master.master_kecamatan.id', 'master.master_kecamatan.name')
                ->orderBy('master.master_kecamatan.id', 'ASC')
                ->paginate($max_data);
    }

    protected function indexKabupatenSearch($max_data, $query)
    {
         return Kecamatan::select(
                'master.master_kecamatan.id',
                'master.master_kecamatan.kode_bps',
                'master.master_kecamatan.name',
                'master.master_kecamatan.long_name',
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                    DB::raw('count(distinct master.master_desa.id) as jumlah_desa'),
                'master.master_kecamatan.updated_at',
                )
                ->join('master.master_desa', DB::raw('substring(master.master_desa.id, 1, 6)'), '=', DB::raw('substring(master.master_kecamatan.id, 1, 6)'))
                ->leftjoin('master.master_user', 'master.master_user.kecamatan_id', '=', 'master.master_kecamatan.id')
                ->where('master_kecamatan.name', 'like', '%' . $query .'%')
                ->orwhere('master_kecamatan.id', '=', '' . $query .'')
                ->groupBy('master.master_kecamatan.id', 'master.master_kecamatan.name')
                ->orderBy('master.master_kecamatan.id', 'ASC')
                ->paginate($max_data);
    }

}
