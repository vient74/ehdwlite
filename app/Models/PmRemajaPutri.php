<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PmRemajaPutri extends Model
{
    use HasFactory;
    
    protected $table  = 'pm_remaja_putri';
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

    protected function showPmRemajaPutriIndex($max_data)
    {
        $remajas = DB::table('layanan.pm_remaja_putri')

                    ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_remaja_putri.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_remaja_putri.kpm_id')
                    ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=',  DB::raw("left(layanan.pm_remaja_putri.id, 16)"))

                    ->select('master.master_meta_sasaran.kk','layanan.pm_remaja_putri.id', 'master.master_meta_sasaran.nik', 'nama', 'master.master_meta_sasaran.desa_id', 
                             'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                              DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),  
                             'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
                             'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm',
                             'pm_remaja_putri.is_active','pm_remaja_putri.actived_at','pm_remaja_putri.last_eval',
                             'pm_remaja_putri.sasaran_id','last_calculate','task_ava','task_val')

                    ->orderBy('layanan.pm_remaja_putri.id', 'ASC')
                    ->cursorPaginate($max_data);

        return $remajas;            
    }     


    protected function showPmRemajaPutriSearch($query, $max_data)
    {
        $remajas = DB::table('layanan.pm_remaja_putri')

                    ->join('master.master_desa', 'master.master_desa.id', '=', 'layanan.pm_remaja_putri.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'layanan.pm_remaja_putri.kpm_id')
                    ->join('master.master_meta_sasaran', 'master.master_meta_sasaran.nik', '=',  DB::raw("left(layanan.pm_remaja_putri.id, 16)"))

                    ->select('master.master_meta_sasaran.kk','layanan.pm_remaja_putri.id', 'master.master_meta_sasaran.nik', 'nama', 'master.master_meta_sasaran.desa_id', 
                             'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                              DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"),  
                             'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
                             'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm',
                             'pm_remaja_putri.is_active','pm_remaja_putri.actived_at','pm_remaja_putri.last_eval',
                             'pm_remaja_putri.sasaran_id','last_calculate','task_ava','task_val')

                
                    ->where('master.master_meta_sasaran.kk',  $query)
                    ->orWhere('master.master_meta_sasaran.nik', $query)
                    ->orWhere('nama', 'like', '%' . $query . '%')
                    ->orderBy('layanan.pm_remaja_putri.id', 'ASC')
                    ->cursorPaginate($max_data)
                    ->withQueryString();

        return $remajas;            
    }     

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    public function kpm()
    {
        return $this->belongsTo(Kpm::class, 'kpm_id');
    }

}

 