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

    protected function indexProvinsi($max_data)
    {
        return Provinsi::select(
                'master.master_provinsi.id',
                'master.master_provinsi.kode_bps',
                'master.master_provinsi.name',
                    DB::raw('count(distinct master.master_kab_kota.id) as kabupaten'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                'master.master_provinsi.updated_at',
                )
               
                ->join('master.master_kab_kota', DB::raw("left(master.master_kab_kota.id, 2)"), '=',  'master.master_provinsi.id')
                ->leftJoin('master.master_user', 'master.master_user.provinsi_id', '=', 'master.master_provinsi.id')
                ->groupBy('master.master_provinsi.id', 'master.master_provinsi.name')
                ->orderBy('master.master_provinsi.id', 'ASC')
                ->paginate($max_data);
                            
    }

    protected function indexProvinsiSearch($max_data, $query)
    {
        return  Provinsi::select(
                'master.master_provinsi.id',
                'master.master_provinsi.kode_bps',
                'master.master_provinsi.name',
                    DB::raw('count(distinct master.master_kab_kota.id) as kabupaten'),
                    DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                'master.master_provinsi.updated_at',
                )
                ->leftJoin('master.master_kab_kota', DB::raw("left(master.master_kab_kota.id, 2)"), '=',  'master.master_provinsi.id')
                ->leftJoin('master.master_user', 'master.master_user.provinsi_id', '=', 'master.master_provinsi.id')
                ->where('master_provinsi.name', 'like', '%' . $query .'%')
                ->orWhere('master_provinsi.id', '=', '' . $query .'')
                ->groupBy('master.master_provinsi.id', 'master.master_provinsi.name')
                ->orderBy('master.master_provinsi.id', 'ASC')
                ->paginate($max_data)
                ->withQueryString();
                            
    }

}
