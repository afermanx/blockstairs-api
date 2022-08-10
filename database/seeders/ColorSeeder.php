<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create([
            'description' => 'Vermelho',
            'hex' => '#ff0000',
            'rgb' => 'rgb(255, 0, 0)',
       ]);
        Color::create([
            'description' => 'Verde',
            'hex' => '#00ff00',
            'rgb' => 'rgb(0, 255, 0)',
        ]);
        Color::create([
            'description' => 'Azul',
            'hex' => '#0000ff',
            'rgb' => 'rgb(0, 0, 255)',
        ]);
        Color::create([
            'description' => 'Amarelo',
            'hex' => '#ffff00',
            'rgb' => 'rgb(255, 255, 0)',
        ]);
        Color::create([
            'description' => 'Laranja',
            'hex' => '#ffa500',
            'rgb' => 'rgb(255, 165, 0)',
        ]);
    }
}
