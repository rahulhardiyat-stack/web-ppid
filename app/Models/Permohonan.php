<?php

namespace App\Models;

use App\Enums\PermohonanStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Permohonan extends Model
{
    /** @use HasFactory<\Database\Factories\PermohonanFactory> */
    use HasUuids, SoftDeletes, Notifiable, HasFactory;

    protected $table = 'permohonans';

    protected $fillable = [
        'no_tiket',
        'pemohon_id',
        'is_ditolak',
        'is_diterima',
        'rincian_informasi',
        'tujuan',
        'cara_memperoleh',
        'cara_mendapat_salinan',
        'status',
        'tgl_batas_jawab',
        'tgl_final',
        'diperpanjang',
    ];

    protected $casts = [
        'status'          => PermohonanStatus::class,
        'tgl_batas_jawab' => 'date',
        'tgl_final'       => 'date',
        'diperpanjang'    => 'boolean',
    ];

}
