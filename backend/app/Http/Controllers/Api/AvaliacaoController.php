<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Optativa;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function store(Request $request, Optativa $optativa)
    {
        $user = $request->user();

        if ($optativa->avaliacoes()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Voce ja avaliou esta optativa.'], 422);
        }

        $data = $request->validate([
            'nota_geral' => 'required|integer|min:1|max:5',
            'nota_didatica' => 'required|integer|min:1|max:5',
            'nota_conteudo' => 'required|integer|min:1|max:5',
            'nota_dificuldade' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:10',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'anonima' => 'boolean',
        ]);

        $avaliacao = $optativa->avaliacoes()->create([
            'user_id' => $user->id,
            ...$data,
            'tags' => $data['tags'] ?? null,
        ]);

        return response()->json($avaliacao, 201);
    }

    public function minhas(Request $request)
    {
        $reviews = $request->user()->avaliacoes()->with('optativa.professor')->latest()->get();
        return response()->json($reviews);
    }
}
