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
        Schema::create('ticket_sequences', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('jenis', 20);                  // permohonan | keberatan
            $t->unsignedSmallInteger('tahun');
            $t->unsignedInteger('terakhir')->default(0);
            $t->unique(['jenis', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_sequences');
    }
};
