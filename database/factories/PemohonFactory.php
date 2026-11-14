<?php

namespace Database\Factories;

use App\Models\Pemohon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pemohon>
 */
class PemohonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nik' => fake()->numerify('###############'),
            'email' => fake()->unique()->safeEmail(),
            'nik_hash' => fake()->unique()->sha256(),
            'no_hp' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'file_identitas' => null,
        ];
    }
}
