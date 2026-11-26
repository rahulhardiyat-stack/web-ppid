<?php

namespace App\Services;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\HariLibur;


class BatasWaktuService
{
    public function hariKerjaKe(CarbonInterface $dari, int $jumlah): Carbon
    {
        $libur = Cache::remember('ppid.hari_libur', 3600, fn () =>
        HariLibur::pluck('tanggal')->map->toDateString()->all());

        $tgl = Carbon::parse($dari)->startOfDay();

        while ($jumlah > 0) {
            $tgl->addDay();
            if ($tgl->isWeekend() || in_array($tgl->toDateString(), $libur, true)) continue;
            $jumlah--;
        }

        return $tgl;
    }
}
