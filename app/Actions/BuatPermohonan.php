<?php

namespace App\Actions;

use App\Enums\PermohonanStatus;
use App\Models\Pemohon;
use App\Models\Permohonan;
use App\Services\BatasWaktuService;
use App\Services\TicketGeneratorService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BuatPermohonan
{
    /**
     * Handle proses pembuatan permohonan informasi baru.
     *
     * @param array $data Data request yang sudah tervalidasi
     * @param UploadedFile $fileIdentitas File KTP yang diunggah
     * @return Permohonan
     */
    public function handle(array $data, UploadedFile $fileIdentitas): Permohonan
    {
        return DB::transaction(function () use ($data, $fileIdentitas) {

            // 1. Simpan File KTP ke private disk
            $pathIdentitas = $fileIdentitas->store('ppid/identitas', 'private');

            // 2. Hash NIK untuk pengecekan data unik
            $nikHash = hash('sha256', $data['nik']);

            // 3. Buat atau Perbarui Data Pemohon
            $pemohon = Pemohon::updateOrCreate(
                ['nik_hash' => $nikHash],
                [
                    'nama'           => $data['nama'],
                    'nik'            => $data['nik'],
                    'email'          => $data['email'],
                    'no_hp'          => $data['no_hp'],
                    'alamat'         => $data['alamat'],
                    'file_identitas' => $pathIdentitas,
                ]
            );

            // 4. Generate Nomor Tiket menggunakan Service (Tipe: permohonan, Prefix: PPID)
            $noTiket = app(TicketGeneratorService::class)->buat('permohonan', 'PPID');

            // 5. Hitung Tanggal Batas Jawab
            $tglBatasJawab = app(BatasWaktuService::class)
                ->hariKerjaKe(now(), config('batas_jawab_hari_kerja', 10));

            // 6. Simpan Permohonan Baru
            $permohonan = $pemohon->permohonan()->create([
                'no_tiket'              => $noTiket,
                'rincian_informasi'     => $data['rincian_informasi'],
                'tujuan'                => $data['tujuan'],
                'cara_memperoleh'       => $data['cara_memperoleh'],
                'cara_mendapat_salinan' => $data['cara_memperoleh'] === 'salinan' ? $data['cara_mendapat_salinan'] : null,
                'status'                => PermohonanStatus::Diterima,
                'tgl_batas_jawab'       => $tglBatasJawab,
                'diperpanjang'          => false,
            ]);

            return $permohonan;
        });
    }
}
