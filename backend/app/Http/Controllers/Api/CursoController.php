<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        return Curso::all();
    }

    public function show(Curso $curso)
    {
        return $curso->load('optativas');
    }
}
