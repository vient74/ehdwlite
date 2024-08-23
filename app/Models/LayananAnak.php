<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LayananAnak extends Model
{
   // use HasFactory, Notifiable;
    use HasFactory;

    protected $table  = 'layanan_anak';
    protected $primaryKey  = 'id';

    protected static function booted()
    {
        $schema = 'layanan';  
        static::addGlobalScope(new SchemaScope($schema));
    }

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

    protected function layananAnak($id) 
    {
        return DB::table('layanan.layanan_anak as la')
                ->select('la.parent_id','la.type','la.start','la.end','la.val','la.kpm_id','la.sign_date','la.quest','la.index_i')
                //->where('la.parent_id', 'LIKE', '' . $id . '|%')
                ->where(DB::raw("left(la.id, 16)"), '=', "". $id . "")
                ->orderBy('index_i')
                ->get();
    }

    protected function menerimaManfaat($id)
    {
        return DB::table('layanan.pm_anak as pm')
                ->select('pm.task_ava','pm.task_val')
                //->where('pm.id', 'LIKE', '' . $id . '|%')
                ->where(DB::raw("left(pm.id, 16)"), '=', "". $id . "")
                ->first();    
    }

}
