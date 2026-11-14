<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_tiket')->unique();
            $table->foreignUuid('pemohon_id')
                ->constrained('pemohon')
                ->cascadeOnDelete();
            $table->text('rincian_informasi');
            $table->text('tujuan');
            $table->string('cara_memperoleh', 20);
            $table->string('cara_mendapat_salinan', 20)->nullable();
            $table->string('status', 20)
                ->default('diterima')->index();
            $table->date('tgl_batas_jawab')->index();
            $table->date('tgl_final')->nullable();
            $table->boolean('diperpanjang')->default(false);
            $table->boolean('is_ditolak')->default(false);
            $table->boolean('is_diterima')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
