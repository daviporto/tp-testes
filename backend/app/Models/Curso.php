<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'codigo', 'departamento', 'descricao'])]
class Curso extends Model
{
    protected $table = 'cursos';

    public function optativas(): HasMany
    {
        return $this->hasMany(Optativa::class);
    }
}
