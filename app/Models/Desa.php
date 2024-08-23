<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchemaScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Desa extends Model
{
    use HasFactory;
    
    protected $table  = 'master_desa';
    protected $primaryKey  = 'id';

    public $incrementing = false;
    //protected $keyType = 'string';

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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

     // Relasi ke desa
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id');
    }

    protected function indexDesa($max_data)
    {

        
        // $desas = DB::table('master.master_desa')
        //         ->join('master.master_meta_kk', 'master.master_desa.id', '=', 'master.master_meta_kk.desa_id')
        //         ->join('master.master_meta_sasaran', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
        //         ->join('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
        //         ->join('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id')
        //         ->select(
        //             'master.master_desa.id',
        //             'master.master_desa.name',
        //             'master.master_desa.long_name',
        //             'master.master_desa.updated_at',
        //             DB::raw('count(distinct master.master_kpm.id) as jumlah_kpm'),
        //             DB::raw('count(distinct master.master_user.id) as jumlah_user'),
        //             DB::raw('count(distinct master.master_meta_kk.kk) as jumlah_kk'),
        //             DB::raw('count(distinct master.master_meta_sasaran.nik) as jumlah_sasaran')
        //         )
        //         ->groupBy('master.master_desa.id', 'master.master_desa.name', 'master.master_desa.long_name')
        //         ->orderBy('master.master_desa.id', 'ASC')
        //         ->cursorPaginate($max_data);
      
        // return $desas;

        $desas = DB::table(DB::raw('(
                    SELECT 
                        master.master_desa.id,
                        master.master_desa.name,
                        master.master_desa.long_name,
                        master.master_desa.updated_at,
                        COUNT(DISTINCT master.master_kpm.id) AS jumlah_kpm,
                        COUNT(DISTINCT master.master_user.id) AS jumlah_user,
                        COUNT(DISTINCT master.master_meta_kk.kk) AS jumlah_kk,
                        COUNT(DISTINCT master.master_meta_sasaran.nik) AS jumlah_sasaran
                    FROM master.master_desa
                    LEFT JOIN master.master_meta_kk ON master.master_desa.id = master.master_meta_kk.desa_id
                    LEFT JOIN master.master_meta_sasaran ON master.master_desa.id = master.master_meta_sasaran.desa_id
                    JOIN master.master_user ON master.master_user.desa_id = master.master_desa.id
                    JOIN master.master_kpm ON master.master_kpm.desa_id = master.master_desa.id
                    GROUP BY master.master_desa.id, master.master_desa.name, master.master_desa.long_name
                ) AS subquery'))
                ->orderBy('id', 'ASC')
                ->cursorPaginate($max_data);

        return $desas;
    }

    
    protected function indexDesaSearch($query,$max_data)
    {
        $desas = DB::table('master.master_desa')
                    ->leftJoin('master.master_meta_kk', 'master.master_desa.id', '=', 'master.master_meta_kk.desa_id')
                    ->leftJoin('master.master_meta_sasaran', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                    ->leftJoin('master.master_user', 'master.master_user.desa_id', '=', 'master.master_desa.id')
                    ->leftJoin('master.master_kpm', 'master.master_kpm.desa_id', '=', 'master.master_desa.id')
                    ->select(
                        'master.master_desa.id',
                        'master.master_desa.name',
                        'master.master_desa.long_name',
                        'master.master_desa.updated_at',
                         DB::raw('count(distinct master.master_kpm.id) as jumlah_kpm'),
                         DB::raw('count(distinct master.master_user.id) as jumlah_user'),
                         DB::raw('count(distinct master.master_meta_kk.kk) as jumlah_kk'),
                         DB::raw('count(distinct master.master_meta_sasaran.nik) as jumlah_sasaran')
                    )
                    ->where("master.master_desa.name", 'like', '%' . $query . '%')
                    //->where("master.master_desa.name", '=', $query)
                    ->orWhere('long_name', 'like', '%' . $query . '%')
                    ->orWhere('master.master_desa.id', $query)
                    ->groupBy('master.master_desa.id', 'master.master_desa.name', 'master.master_desa.long_name')
                    ->orderBy('master.master_desa.id', 'ASC')
                    ->cursorPaginate($max_data);

        return $desas;            

    }
}
