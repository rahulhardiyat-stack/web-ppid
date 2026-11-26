<?php


namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\TicketSequence;

class TicketGeneratorService
{
    public function buat(string $jenis, string $prefix): string
    {
        $tahun = now()->year;

        return DB::transaction(function () use ($jenis, $prefix, $tahun) {

            TicketSequence::insertOrIgnore([
                'id' => (new TicketSequence())->newUniqueId(),
                'jenis' => $jenis,
                'tahun' => $tahun,
                'terakhir' => 0
            ]);

            $seq = TicketSequence::where([
                'jenis' => $jenis,
                'tahun' => $tahun
            ])->lockForUpdate()->firstOrFail();
            $seq->increment('terakhir');

            return sprintf('%s-%d-%06d', $prefix, $tahun, $seq->terakhir);
        });
    }
}
