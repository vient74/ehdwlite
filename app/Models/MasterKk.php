<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterKk extends Model
{
    // use HasFactory, Notifiable;
    use HasFactory;

    protected $table  = 'master_meta_kk';
    protected $primaryKey  = 'kk';

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
        'kk',
        'is_active',
        'kpm_id',
        'nama_kepala_keluarga',
        'rt',
        'rw',
        'alamat',
        'updated_at',
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
            'updated_at' => 'datetime',
        ];
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    protected function indexMasterKk($max_data)
    {
        return MasterKk::join('master.master_desa', 'master_meta_kk.desa_id', '=', 'master.master_desa.id')
                ->join('master.master_kpm', 'master_kpm.desa_id', '=', 'master.master_desa.id')
                ->select('master_meta_kk.kk', 'master.master_desa.id as kode_desa','master_meta_kk.nama_kepala_keluarga', 
                         'master_meta_kk.rt', 'master_meta_kk.rw',
                         'master_meta_kk.alamat', 'master_meta_kk.task_ava', 'master_meta_kk.task_val', 
                         'master_meta_kk.created_at', 'master_meta_kk.updated_at',
                         'master.master_desa.name as nama_desa',
                         'master.master_kpm.name as nama_kpm')   
                ->orderBy('master_meta_kk.kk', 'ASC')   
                ->cursorPaginate($max_data)
                ->withQueryString();
    }

    protected function indexMasterKkSearch($max_data,$query)
    {
        return MasterKk::select('master_meta_kk.kk','master.master_desa.id as kode_desa', 'master_meta_kk.nama_kepala_keluarga', 'master_meta_kk.rt', 'master_meta_kk.rw',
                            'master_meta_kk.alamat', 'master_meta_kk.task_ava', 'master_meta_kk.task_val', 'master_meta_kk.created_at', 'master_meta_kk.updated_at',
                            'master.master_desa.name as nama_desa',
                            'master.master_kpm.name as nama_kpm')  
                ->join('master.master_desa', 'master_meta_kk.desa_id', '=', 'master.master_desa.id')
                ->join('master.master_kpm', 'master_desa.id', '=', 'master.master_kpm.desa_id')
                ->where('nama_kepala_keluarga', 'like', '' . $query . '%')
                ->orWhere('master_meta_kk.kk', $query)
                ->orWhere('master_meta_kk.desa_id', $query)
                ->cursorPaginate($max_data)
                ->withQueryString();

    }    

    protected function indexKkByKpmSearch($query, $max_data)
    {
         return MasterKk::select('master_meta_kk.kk', 'master.master_desa.id as kode_desa',
                    'master_meta_kk.nama_kepala_keluarga', 'master_meta_kk.rt', 'master_meta_kk.rw',
                    'master_meta_kk.alamat', 'master_meta_kk.task_ava', 'master_meta_kk.task_val', 
                    'master_meta_kk.created_at', 'master_meta_kk.updated_at',
                    'master.master_desa.name as nama_desa',
                    'master.master_kpm.name as nama_kpm')   
                ->join('master.master_desa', 'master_desa.id', '=', 'master.master_meta_kk.desa_id')    
                ->join('master.master_kpm', 'master_kpm.desa_id', '=', 'master.master_desa.id')
                ->where('master.master_kpm.id',  $query)    
                ->orderBy('master_meta_kk.kk', 'ASC')        
                ->cursorPaginate($max_data)
                ->withQueryString();
                     
    }

    protected function showMetaKkSearch($query, $max_data)
    {
        return DB::table('master.master_meta_kk')
                    ->select('kk','is_active', 'actived_at', 'last_eval', 'nama_kepala_keluarga', 'desa_id', 'name as desa', 'alamat', 
                             'task_ava', 'task_val', 'master.master_meta_kk.updated_at')
                    ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_kk.desa_id')
                    ->where('kk',  $query)
                    ->orWhere('nama_kepala_keluarga', 'like', '%' . $query . '%')
                    ->orderBy('kk', 'ASC')
                    ->cursorPaginate($max_data);

    }
 
    protected function showMetaKk($id, $max_data)
    {
        return DB::table('master.master_meta_kk')
                    ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_kk.desa_id')
                    ->select('kk','is_active', 'actived_at', 'last_eval', 'nama_kepala_keluarga', 'desa_id', 'name as desa', 'alamat', 
                             'task_ava', 'task_val', 'master.master_meta_kk.updated_at')
                    ->where('desa_id', $id)
                    ->orderBy('kk', 'ASC')
                    ->cursorPaginate($max_data);            
    }

}
