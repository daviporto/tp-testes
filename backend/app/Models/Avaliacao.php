<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['user_id', 'optativa_id', 'nota_geral', 'nota_didatica', 'nota_conteudo', 'nota_dificuldade', 'comentario', 'tags', 'anonima'])]
class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'anonima' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function optativa(): BelongsTo
    {
        return $this->belongsTo(Optativa::class);
    }
}
