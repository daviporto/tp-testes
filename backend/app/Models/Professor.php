<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'email', 'departamento'])]
class Professor extends Model
{
    protected $table = 'professores';

    public function optativas(): HasMany
    {
        return $this->hasMany(Optativa::class);
    }
}
