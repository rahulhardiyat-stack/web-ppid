<?php


namespace App\Enums;

use App\Enums\Concerns\AlurStatus;

enum PermohonanStatus: string
{
    use AlurStatus;

    case Diterima = 'diterima';
    case Diproses = 'diproses';
    case Diperpanjang = 'diperpanjang';
    case Dikabulkan = 'dikabulkan';
    case DikabulkanSebagian = 'dikabulkan_sebagian';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Diterima => 'Diterima',
            self::Diproses => 'Sedang Diproses',
            self::Diperpanjang => 'Diperpanjang',
            self::Dikabulkan => 'Dikabulkan',
            self::DikabulkanSebagian => 'Dikabulkan Sebagian',
            self::Ditolak => 'Ditolak',
        };
    }

    public function bolehKe(): array
    {
        return match ($this) {
            self::Diterima => [self::Diproses, self::Ditolak],
            self::Diproses => [self::Diperpanjang, self::Dikabulkan, self::DikabulkanSebagian, self::Ditolak],
            self::Diperpanjang => [self::Dikabulkan, self::DikabulkanSebagian, self::Ditolak],
            default => [],
        };
    }
    public function final(): bool { return empty($this->bolehKe()); }

    public static function finalValues(): array
    {
        return array_map(fn ($c) => $c->value,
            array_filter(self::cases(), fn ($c) => $c->final()));
    }
}

