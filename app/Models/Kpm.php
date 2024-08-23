<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
