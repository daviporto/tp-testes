<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professor;

class ProfessorController extends Controller
{
    public function index()
    {
        return Professor::all();
    }

    public function show(Professor $professor)
    {
        return $professor->load('optativas');
    }
}
