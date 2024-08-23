<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LayananCatin extends Model
{
    use HasFactory;

    protected $table  = 'layanan_catin';
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

    protected function layananCatin($id) 
    {
        return DB::table('layanan.layanan_catin as lc')
                ->select('lc.parent_id','lc.type','lc.start','lc.end','lc.val','lc.kpm_id','lc.sign_date','lc.quest','lc.index_i')
                ->where(DB::raw("left(lc.id, 16)"), '=', "". $id . "")
                ->orderBy('index_i')
                ->get();
 
    }

    protected function menerimaManfaat($id)
    {
        return DB::table('layanan.pm_catin as pm')
                ->select('pm.task_ava','pm.task_val')
                ->where(DB::raw("left(pm.id, 16)"), '=', "". $id . "")
                ->first();    
    }
}
