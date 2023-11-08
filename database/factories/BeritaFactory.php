<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => implode(' ', $this->faker->sentences(mt_rand(2, 4))),
            'slug' => $this->faker->slug(),
            'body' => collect($this->faker->paragraphs(mt_rand(5, 8)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(''),
        ];
    }
}
