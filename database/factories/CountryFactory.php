<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Country>
 */
class CountryFactory extends Factory 
{
    /**
     * Define the model's default state.
     * factory ini buat generate data country secara otomatis
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->country(); //menggunakan faker untuk generate nama negara secara acak dan unik
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
