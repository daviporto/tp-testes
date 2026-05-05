<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvaliacaoController;
use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\OptativaController;
use App\Http\Controllers\Api\ProfessorController;
use App\Http\Controllers\Api\Admin\AvaliacaoController as AdminAvaliacaoController;
use Illuminate\Support\Facades\Route;

// Auth (public)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Auth (protected)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Avaliacoes
    Route::post('/optativas/{optativa}/avaliacoes', [AvaliacaoController::class, 'store']);
    Route::get('/avaliacoes/minha', [AvaliacaoController::class, 'minhas']);

    // Admin
    Route::middleware('admin')->group(function () {
        Route::get('/admin/avaliacoes', [AdminAvaliacaoController::class, 'index']);
        Route::delete('/admin/avaliacoes/{avaliacao}', [AdminAvaliacaoController::class, 'destroy']);
    });
});

// Public routes (without auth)
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{curso}', [CursoController::class, 'show']);

Route::get('/professores', [ProfessorController::class, 'index']);
Route::get('/professores/{professor}', [ProfessorController::class, 'show']);

Route::get('/optativas', [OptativaController::class, 'index']);
Route::get('/optativas/{optativa}', [OptativaController::class, 'show']);
