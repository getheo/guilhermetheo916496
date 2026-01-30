<?php

namespace Database\Factories;

use App\Models\Artista;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artista_id' => Artista::all()->random()->id,
            'alb_titulo' => fake()->realText(50),
            'alb_data_lancamento' => fake()->date(),
            'alb_status' => fake()->boolean(),
        ];
    }
}
