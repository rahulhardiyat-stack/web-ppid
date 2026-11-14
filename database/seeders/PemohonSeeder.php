<?php

namespace Database\Seeders;

use App\Models\Pemohon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PemohonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        Pemohon::truncate();
        Schema::enableForeignKeyConstraints();

        Pemohon::factory(5)->create();

       /* Pemohon::factory()->count(10)->create([
            'nama' => 'Budi Santoso',
            'nik' => '3301234567890123',
            'nik_hash' => '2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae',
            'email' => 'pemohon@example.com',
            'no_hp' => '081234567890',
            'file_identitas' => null,
        ]);*/
    }
}
