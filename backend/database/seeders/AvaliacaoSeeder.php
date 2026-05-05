<?php

namespace Database\Seeders;

use App\Models\Avaliacao;
use Illuminate\Database\Seeder;

class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        $avaliacoes = [
            ['user_id' => 2, 'optativa_id' => 1, 'nota_geral' => 5, 'nota_didatica' => 5, 'nota_conteudo' => 5, 'nota_dificuldade' => 4, 'comentario' => 'Excelente optativa! Professor explica muito bem e o conteudo e muito relevante para quem quer seguir na area de IA.', 'tags' => json_encode(['projetos praticos', 'boa didatica']), 'anonima' => false],
            ['user_id' => 3, 'optativa_id' => 1, 'nota_geral' => 4, 'nota_didatica' => 4, 'nota_conteudo' => 5, 'nota_dificuldade' => 5, 'comentario' => 'Materia densa mas muito boa. Bastante leitura e trabalhos.', 'tags' => json_encode(['muita leitura', 'trabalhos dificeis']), 'anonima' => true],
            ['user_id' => 4, 'optativa_id' => 2, 'nota_geral' => 3, 'nota_didatica' => 3, 'nota_conteudo' => 4, 'nota_dificuldade' => 3, 'comentario' => 'Conteudo interessante mas a didatica poderia ser melhor. Provas muito longas.', 'tags' => json_encode(['provas longas']), 'anonima' => false],
            ['user_id' => 5, 'optativa_id' => 2, 'nota_geral' => 4, 'nota_didatica' => 4, 'nota_conteudo' => 4, 'nota_dificuldade' => 3, 'comentario' => 'Gostei bastante dos projetos praticos. Aprendi muito sobre sistemas distribuidos.', 'tags' => json_encode(['projetos praticos']), 'anonima' => false],
            ['user_id' => 2, 'optativa_id' => 4, 'nota_geral' => 2, 'nota_didatica' => 2, 'nota_conteudo' => 3, 'nota_dificuldade' => 5, 'comentario' => 'Materia muito dificil, professor cobra demais e nao da suporte. So recomendo se tiver base muito forte.', 'tags' => json_encode(['dificil', 'pouco suporte']), 'anonima' => true],
            ['user_id' => 6, 'optativa_id' => 5, 'nota_geral' => 5, 'nota_didatica' => 5, 'nota_conteudo' => 4, 'nota_dificuldade' => 4, 'comentario' => 'Otima professora! A materia e desafiadora mas ela explica de um jeito que fica facil entender.', 'tags' => json_encode(['boa didatica', 'monitoria boa']), 'anonima' => false],
            ['user_id' => 3, 'optativa_id' => 7, 'nota_geral' => 4, 'nota_didatica' => 4, 'nota_conteudo' => 4, 'nota_dificuldade' => 3, 'comentario' => 'Computacao grafica e muito legal. Os trabalhos de OpenGL sao trabalhosos mas valem a pena.', 'tags' => json_encode(['projetos praticos', 'trabalhoso']), 'anonima' => false],
        ];

        foreach ($avaliacoes as $avaliacao) {
            Avaliacao::create($avaliacao);
        }
    }
}
