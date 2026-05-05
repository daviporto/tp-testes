<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function index()
    {
        return Avaliacao::with(['user', 'optativa'])->latest()->get();
    }

    public function destroy(Avaliacao $avaliacao)
    {
        $avaliacao->delete();
        return response()->json(['message' => 'Avaliacao removida.']);
    }
}
