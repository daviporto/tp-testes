<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'codigo', 'curso_id', 'professor_id', 'semestre', 'descricao', 'creditos'])]
class Optativa extends Model
{
    protected $table = 'optativas';

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }
}
