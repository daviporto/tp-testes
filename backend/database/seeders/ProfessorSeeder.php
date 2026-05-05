<?php

namespace Database\Seeders;

use App\Models\Professor;
use Illuminate\Database\Seeder;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professores = [
            ['nome' => 'Dr. Marcos Almeida', 'email' => 'marcos@ufmg.br', 'departamento' => 'DCC'],
            ['nome' => 'Dra. Juliana Pereira', 'email' => 'juliana@ufmg.br', 'departamento' => 'DCC'],
            ['nome' => 'Dr. Ricardo Lopes', 'email' => 'ricardo@ufmg.br', 'departamento' => 'DEE'],
            ['nome' => 'Dra. Patricia Nunes', 'email' => 'patricia@ufmg.br', 'departamento' => 'MAT'],
            ['nome' => 'Dr. Fernando Costa', 'email' => 'fernando@ufmg.br', 'departamento' => 'DELT'],
            ['nome' => 'Dra. Beatriz Ramos', 'email' => 'beatriz@ufmg.br', 'departamento' => 'DCC'],
        ];

        foreach ($professores as $professor) {
            Professor::create($professor);
        }
    }
}
