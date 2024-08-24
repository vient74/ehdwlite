<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Kpm extends Model
{
   // use HasFactory, Notifiable;
    use HasFactory;

    protected $table  = 'master_kpm';
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
        'role_id',
        'desa_id',
        'status',
        'nik',
        'username',
        'email',
        'name',
        'jenis_kelamin',
        'tgl_lahir',
        'nomor_telpon',
        'alamat',
        'mengikuti_pelatihan',
        'status_pendidikan',
        'val',
        'updated_at'
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

    protected function indexKpm($max_data)
    {
        $sql = Kpm::select('master.master_kpm.id','nik','master.master_kpm.name','username','email','nomor_telpon','desa_id', 
                            'master.master_desa.name as desa' ,'status','master_kpm.updated_at')
                ->join('master.master_desa','master.master_desa.id','=','master.master_kpm.desa_id');

                if (Auth::user()->role->tag == 'admin_prov') {
                    $sql->where(DB::raw('substring(master.master_kpm.desa_id, 1, 2)'), '=', Auth::user()->provinsi_id);
                }

        $data = $sql->orderBy('master.master_kpm.id', 'ASC')
                    ->cursorPaginate($max_data); 
        
        return $data;            
                    
    }

}
