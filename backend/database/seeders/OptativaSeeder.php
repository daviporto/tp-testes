<?php

namespace Database\Seeders;

use App\Models\Optativa;
use Illuminate\Database\Seeder;

class OptativaSeeder extends Seeder
{
    public function run(): void
    {
        $optativas = [
            ['nome' => 'Inteligencia Artificial', 'codigo' => 'DCC888', 'curso_id' => 1, 'professor_id' => 1, 'semestre' => '2024/2', 'descricao' => 'Fundamentos de IA, busca, planejamento, aprendizado de maquina.', 'creditos' => 4],
            ['nome' => 'Sistemas Distribuidos', 'codigo' => 'DCC623', 'curso_id' => 1, 'professor_id' => 2, 'semestre' => '2024/2', 'descricao' => 'Arquitetura de sistemas distribuidos, consistencia, replicacao.', 'creditos' => 4],
            ['nome' => 'Topicos em Engenharia de Software', 'codigo' => 'DCC625', 'curso_id' => 1, 'professor_id' => 6, 'semestre' => '2024/2', 'descricao' => 'Topicos avancados em engenharia de software, testes, CI/CD.', 'creditos' => 4],
            ['nome' => 'Processamento de Sinais', 'codigo' => 'EEL706', 'curso_id' => 2, 'professor_id' => 3, 'semestre' => '2024/2', 'descricao' => 'Transformadas, filtros digitais, processamento de audio.', 'creditos' => 4],
            ['nome' => 'Algebra Linear Computacional', 'codigo' => 'MAT016', 'curso_id' => 3, 'professor_id' => 4, 'semestre' => '2024/2', 'descricao' => 'Metodos numericos para algebra linear com aplicacoes.', 'creditos' => 4],
            ['nome' => 'Controle Digital', 'codigo' => 'ECA003', 'curso_id' => 4, 'professor_id' => 5, 'semestre' => '2024/2', 'descricao' => 'Sistemas de controle em tempo discreto, implementacao digital.', 'creditos' => 4],
            ['nome' => 'Computacao Grafica', 'codigo' => 'DCC880', 'curso_id' => 1, 'professor_id' => 1, 'semestre' => '2024/1', 'descricao' => 'Renderizacao, modelagem 3D, OpenGL.', 'creditos' => 4],
            ['nome' => 'Robótica Movel', 'codigo' => 'ECA010', 'curso_id' => 4, 'professor_id' => 5, 'semestre' => '2024/1', 'descricao' => 'Localizacao, mapeamento, navegacao autonoma.', 'creditos' => 4],
        ];

        foreach ($optativas as $optativa) {
            Optativa::create($optativa);
        }
    }
}
