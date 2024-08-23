<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterSasaran extends Model
{
    // use HasFactory, Notifiable;
    use HasFactory;

    protected $table  = 'master_meta_sasaran';
    protected $primaryKey  = 'nik';

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
        'nik',
        'is_active',
        'kk',
        'desa_id',
        'dusun_id',
        'kpm_id',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'nomor_telpon',
        'nama_ayah',
        'nama_ibu',
        'status_keluarga',
        'status' 
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    public function kpm()
    {
        return $this->belongsTo(Kpm::class, 'kpm_id');
    }

    protected function indexSasaran($max_data)
    {
      $desas = DB::table('master.master_meta_sasaran')
                ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                ->join('master.master_kpm', 'master.master_kpm.id', '=', 'master.master_meta_sasaran.kpm_id')
                ->select('kk', 'master.master_meta_sasaran.nik', 'is_active', 'nama', 'master.master_meta_sasaran.desa_id', 
                        'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                        DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"), // Menghitung umur
                        'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga',  'master.master_meta_sasaran.created_at',
                        'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm', 'master.master_desa.id as desa_id')
                ->orderBy('kk', 'ASC')
                ->cursorPaginate($max_data);
                
        return $desas;            
    }     

    protected function indexSasaranSearch($query, $max_data)
    {
        $desas = DB::table('master.master_meta_sasaran')
                    ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'master.master_meta_sasaran.kpm_id')
                    ->select('kk', 'master.master_meta_sasaran.nik', 'is_active', 'nama', 'master.master_meta_sasaran.desa_id', 
                        'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                        DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"), // Menghitung umur
                        'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga',  'master.master_meta_sasaran.created_at',
                        'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm', 'master.master_desa.id as kode_desa')
                   
                    ->where('master.master_meta_sasaran.kk',  $query)
                    ->orWhere('master.master_meta_sasaran.nik', $query)
                    ->orWhere('master.master_meta_sasaran.nama', 'like', '' . $query . '%')
                    ->orWhere('master.master_kpm.name', 'like', '' . $query . '%')
                    ->orWhere('master.master_desa.id', $query)
                    ->orWhere('master.master_kpm.id', $query)
                    ->orderBy('master_meta_sasaran.updated_at', 'DESC')
                    ->cursorPaginate($max_data);
                   
        return $desas;            
    }

    protected function showMetaSasaran($id, $max_data)
    {
        $desas = DB::table('master.master_meta_sasaran')
                ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                ->join('master.master_kpm', 'master.master_kpm.id', '=', 'master.master_meta_sasaran.kpm_id')
                ->select('kk', 'master.master_meta_sasaran.nik', 'is_active', 'nama', 'master.master_meta_sasaran.desa_id', 
                        'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                        DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"), // Menghitung umur
                        'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga', 
                        'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm')
                ->where('master.master_meta_sasaran.desa_id', $id)
                ->orderBy('kk', 'ASC')
                ->cursorPaginate($max_data);

        return $desas;            
    }   
    
    protected function indexSasaranByKpmSearch($query, $max_data)
    {
        $desas = DB::table('master.master_meta_sasaran')
                    ->join('master.master_desa', 'master.master_desa.id', '=', 'master.master_meta_sasaran.desa_id')
                    ->join('master.master_kpm', 'master.master_kpm.id', '=', 'master.master_meta_sasaran.kpm_id')
                    ->select('kk', 'master.master_meta_sasaran.nik', 'is_active', 'nama', 'master.master_meta_sasaran.desa_id', 
                        'master.master_desa.name as desa', 'master.master_meta_sasaran.tgl_lahir', 
                        DB::raw("EXTRACT(YEAR FROM AGE(CURRENT_DATE, master.master_meta_sasaran.tgl_lahir)) as umur"), // Menghitung umur
                        'master.master_meta_sasaran.jenis_kelamin', 'status_keluarga',  'master.master_meta_sasaran.created_at',
                        'master.master_meta_sasaran.updated_at', 'master.master_kpm.name as nama_kpm', 'master.master_desa.id as kode_desa')
                    ->where('master.master_kpm.id', $query)
                    ->orderBy('master_meta_sasaran.updated_at', 'DESC')
                    ->cursorPaginate($max_data);
                   
        return $desas;            
    }

    public function getSasaranByAreaCode($code)
    {
        return DB::table('master.master_meta_sasaran')->where('desa_id', $code)->count();  
    }
    
   


}
