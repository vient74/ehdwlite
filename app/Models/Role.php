<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'master.roles';
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       // 'id',
        'name',
    ];


    public static function getRole($roleId)
    {
        $role = self::find($roleId);
        return $role ? $role->name : 'Unknown';
    }

    
}
