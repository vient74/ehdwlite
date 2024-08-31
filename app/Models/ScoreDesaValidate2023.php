<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreDesaValidate2023 extends Model
{
    use HasFactory;
    protected $table  = 'score_desa_validate_2023';
    protected $primaryKey  = 'id';

    public $incrementing = false;
    //protected $keyType = 'string';

    protected static function booted()
    {
        $schema = 'score_card';  
        static::addGlobalScope(new SchemaScope($schema));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
    ];
    
}
 
