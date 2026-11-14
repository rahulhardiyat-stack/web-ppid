<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;

class Pemohon extends Model
{
    use HasUuids, SoftDeletes, Notifiable, HasFactory;

    protected $table = 'pemohon';

    protected $fillable = [
        'nama',
        'nik',
        'nik_hash',
        'email',
        'alamat',
        'no_hp',
        'file_identitas',
    ];

    protected $hidden = [
        'nik',
        'nik_hash',
        'file_identitas',
    ];

    protected $casts = [
        'nik' => 'encrypted'
    ];

    public static function truncate()
    {
    }

    public function permohonan(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

}
