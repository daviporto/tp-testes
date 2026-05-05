<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            ['nome' => 'Ciencia da Computacao', 'codigo' => 'CC', 'departamento' => 'DCC', 'descricao' => 'Curso de graduacao em Ciencia da Computacao'],
            ['nome' => 'Engenharia Eletrica', 'codigo' => 'EE', 'departamento' => 'DEE', 'descricao' => 'Curso de graduacao em Engenharia Eletrica'],
            ['nome' => 'Matematica', 'codigo' => 'MAT', 'departamento' => 'MAT', 'descricao' => 'Curso de graduacao em Matematica'],
            ['nome' => 'Engenharia de Controle', 'codigo' => 'ECA', 'departamento' => 'DELT', 'descricao' => 'Curso de graduacao em Engenharia de Controle e Automacao'],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
