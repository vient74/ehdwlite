<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\SchemaScope;
use Illuminate\Support\Facades\DB;

class Provinsi extends Model
{
    // use HasFactory, Notifiable;
    use HasFactory;

    protected $table  = 'master_provinsi';
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
        'name' 
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
        return Provinsi::select(
                'master.master_provinsi.id',
                'master.master_provinsi.kode_bps',
                'master.master_provinsi.name',
                    DB::raw('count(distinct master.master_kecamatan.id) as kecamatan'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                'master.master_provinsi.updated_at',
                )
                ->join('master.master_kecamatan', DB::raw('substring(master.master_kecamatan.id, 1, 2)'), '=', DB::raw('substring(master.master_provinsi.id, 1, 2)'))
                ->join('master.master_user', 'master.master_user.provinsi_id', '=', 'master.master_provinsi.id')
                ->groupBy('master.master_provinsi.id', 'master.master_provinsi.name')
                ->orderBy('master.master_provinsi.id', 'ASC')
                ->paginate($max_data);
                            
    }

    protected function indexKabupatenSearch($max_data, $query)
    {
        return  Provinsi::select(
                'master.master_provinsi.id',
                'master.master_provinsi.kode_bps',
                'master.master_provinsi.name',
                    DB::raw('count(distinct master.master_kecamatan.id) as kecamatan'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                'master.master_provinsi.updated_at',
                )
                ->join('master.master_kecamatan', DB::raw('substring(master.master_kecamatan.id, 1, 2)'), '=', DB::raw('substring(master.master_provinsi.id, 1, 2)'))
                ->join('master.master_user', 'master.master_user.provinsi_id', '=', 'master.master_provinsi.id')
                ->where('master_provinsi.name', 'like', '%' . $query .'%')
                ->groupBy('master.master_provinsi.id', 'master.master_provinsi.name')
                ->orderBy('master.master_provinsi.id', 'ASC')
                ->paginate($max_data)
                ->withQueryString();
                            
    }

}
