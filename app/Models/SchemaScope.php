<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class SchemaScope implements Scope
{
    protected $schema;

    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->from($this->schema . '.' . $model->getTable());
    }
}

?>