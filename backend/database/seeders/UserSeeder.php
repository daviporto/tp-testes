<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ufmg.br',
            'password' => 'password',
            'matricula' => '2024000001',
            'curso' => 'Ciencia da Computacao',
            'role' => 'admin',
        ]);

        $alunos = [
            ['name' => 'Ana Silva', 'email' => 'ana@ufmg.br', 'matricula' => '2024000002', 'curso' => 'Ciencia da Computacao'],
            ['name' => 'Bruno Costa', 'email' => 'bruno@ufmg.br', 'matricula' => '2024000003', 'curso' => 'Engenharia Eletrica'],
            ['name' => 'Carla Oliveira', 'email' => 'carla@ufmg.br', 'matricula' => '2024000004', 'curso' => 'Matematica'],
            ['name' => 'Daniel Souza', 'email' => 'daniel@ufmg.br', 'matricula' => '2024000005', 'curso' => 'Engenharia de Controle'],
            ['name' => 'Elena Santos', 'email' => 'elena@ufmg.br', 'matricula' => '2024000006', 'curso' => 'Ciencia da Computacao'],
        ];

        foreach ($alunos as $aluno) {
            User::create(array_merge($aluno, [
                'password' => 'password',
                'role' => 'aluno',
            ]));
        }
    }
}
