<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nombre = ucfirst($this->faker->unique()->words(random_int(2, 4), true));
        $this->faker->addProvider(new \Mmo\Faker\PicsumProvider($this->faker));
        return [
            'nombre' => $nombre,
            'slug' => Str::slug($nombre),
            'descripcion' => $this->faker->text(),
            'pvp' => random_int(1, 999),
            'stock' => random_int(0, 500),
            'user_id'=> User::all()->random()->id,
            'imagen' => 'articles/'.$this->faker->picsum('public/storage/articles', 600, 480, null, false)
        ];
    }
}
