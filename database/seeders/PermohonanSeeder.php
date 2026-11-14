<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara agar truncate berhasil
        Schema::disableForeignKeyConstraints();
        DB::table('permohonans')->truncate();
        Schema::enableForeignKeyConstraints();

        // Generate 20 data permohonan menggunakan Factory
        Permohonan::factory()->count(5)->create();
    }
}
