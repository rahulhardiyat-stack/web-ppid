<?php

namespace Database\Factories;

use App\Models\Pemohon;
use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permohonan>
 */
class PermohonanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Permohonan::class;
    public function definition(): array
    {
        $status = $this->faker->randomElement(['diterima', 'diproses', 'selesai', 'ditolak']);
        $isDitolak = $status === 'ditolak';
        $isDiterima = in_array($status, ['diterima', 'diproses', 'selesai']);

        return [
            'id' => Str::uuid(),
            'no_tiket' => 'TKT-' . $this->faker->unique()->date('Ymd') . '-' . $this->faker->unique()->randomNumber(4, true),
            // Jika kamu sudah punya PemohonFactory, gunakan: Pemohon::factory()
            // Atau ambil UUID random jika data pemohon sudah diseder terpisah
            'pemohon_id' => Pemohon::factory(),
            'rincian_informasi' => $this->faker->paragraph(),
            'tujuan' => $this->faker->sentence(),
            'cara_memperoleh' => $this->faker->randomElement(['Melihat', 'Membaca', 'Mendengarkan', 'Mencatat']),
            'cara_mendapat_salinan' => $this->faker->randomElement(['Hardcopy', 'Softcopy', null]),
            'status' => $status,
            'tgl_batas_jawab' => $this->faker->dateTimeBetween('now', '+10 days')->format('Y-m-d'),
            'tgl_final' => $status === 'selesai' ? $this->faker->dateTimeBetween('-5 days', 'now')->format('Y-m-d') : null,
            'diperpanjang' => $this->faker->boolean(20), // 20% kemungkinan diperpanjang
            'is_ditolak' => $isDitolak,
            'is_diterima' => $isDiterima,
        ];
    }
}
