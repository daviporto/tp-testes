<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Optativa;
use Illuminate\Http\Request;

class OptativaController extends Controller
{
    public function index(Request $request)
    {
        $query = Optativa::with(['professor', 'curso'])->withCount('avaliacoes');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        $optativas = $query->get()->map(function ($optativa) {
            $optativa->media_geral = round($optativa->avaliacoes()->avg('nota_geral') ?? 0, 1);
            $optativa->total_avaliacoes = $optativa->avaliacoes_count;
            return $optativa;
        });

        return response()->json($optativas);
    }

    public function show(Request $request, Optativa $optativa)
    {
        $optativa->load(['professor', 'curso', 'avaliacoes.user']);

        $user = $request->user();

        if ($user && $user->isAdmin()) {
            $reviews = $optativa->avaliacoes;
        } elseif ($user && $user->hasPostedReview()) {
            $reviews = $optativa->avaliacoes->map(function ($review) {
                if ($review->anonima) {
                    $review->user->name = 'Aluno Anonimo';
                }
                return $review;
            });
        } else {
            $reviews = [];
        }

        return response()->json([
            'optativa' => $optativa,
            'reviews' => $reviews,
            'user_has_posted' => $user ? $user->hasPostedReview() : false,
            'has_already_reviewed' => $user ? $optativa->avaliacoes()->where('user_id', $user->id)->exists() : false,
        ]);
    }
}
