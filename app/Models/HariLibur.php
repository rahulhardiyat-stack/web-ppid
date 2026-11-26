<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Cache;

class HariLibur extends Model
{
    // Hanya gunakan HasUuids, hapus SoftDeletes
    use HasUuids;

    protected $table = 'hari_libur';
    public $timestamps = false;

    // Sesuaikan dengan kolom yang ada di tabel Anda
    protected $fillable = ['tanggal', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Otomatis hapus cache setiap ada perubahan atau penghapusan data
    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('ppid.hari_libur');
        });

        // Event 'deleted' ini tetap akan berjalan saat Anda melakukan hard-delete
        static::deleted(function () {
            Cache::forget('ppid.hari_libur');
        });
    }
}
