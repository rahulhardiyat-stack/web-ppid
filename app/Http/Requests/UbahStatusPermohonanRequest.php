<?php

namespace App\Http\Requests;

use App\Enums\PermohonanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UbahStatusPermohonanRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     * (Asumsinya hanya admin/petugas PPID yang bisa, bisa juga dicek via Policy).
     */
    public function authorize(): bool
    {
        // Pastikan hanya user yang sudah login yang bisa memproses ini
        return auth()->check();
    }

    /**
     * Aturan validasi form.
     */
    public function rules(): array
    {
        return [
            // Status wajib diisi dan harus berupa salah satu nilai dari Enum PermohonanStatus
            'status'  => ['required', new Enum(PermohonanStatus::class)],

            // Catatan wajib diisi jika status ditolak atau diperpanjang
            'catatan' => [
                'required_if:status,' . PermohonanStatus::Ditolak->value . ',' . PermohonanStatus::Diperpanjang->value,
                'nullable',
                'string',
                'max:2000'
            ],

            // Berkas jawaban/lampiran (opsional, tapi jika diunggah ada batasannya)
            'berkas'  => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,zip,rar',
                'max:' . config('ppid.upload.max_jawaban_kb', 10240) // Default max 10MB
            ],
        ];
    }

    /**
     * Kustomisasi pesan error (Bahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'status.required'     => 'Status permohonan wajib dipilih.',
            'status.Illuminate\Validation\Rules\Enum' => 'Status yang dipilih tidak valid.',
            'catatan.required_if' => 'Catatan/Alasan wajib diisi untuk status Ditolak atau Diperpanjang.',
            'catatan.max'         => 'Catatan maksimal 2000 karakter.',
            'berkas.file'         => 'Berkas lampiran harus berupa file.',
            'berkas.mimes'        => 'Format berkas lampiran harus PDF, Word, atau Arsip (ZIP/RAR).',
            'berkas.max'          => 'Ukuran berkas lampiran maksimal 10MB.',
        ];
    }

    /**
     * Anda juga bisa menambahkan validasi kustom setelah validasi utama berjalan.
     * Misalnya, mengecek apakah transisi status diizinkan sesuai method bolehKe() di Enum Anda.
     */
    protected function passedValidation(): void
    {
        // Ambil permohonan dari route parameter (misal: route('permohonan.update-status', $permohonan->id))
        $permohonan = $this->route('permohonan');

        // Ambil status baru yang diinput
        $statusBaru = PermohonanStatus::tryFrom($this->status);

        // Cek menggunakan fungsi bolehKe() yang ada di Enum Anda
        if ($permohonan && $statusBaru) {
            $statusLama = is_string($permohonan->status) ? PermohonanStatus::tryFrom($permohonan->status) : $permohonan->status;

            if (!in_array($statusBaru, $statusLama->bolehKe(), true)) {
                abort(422, 'Perubahan ke status tersebut tidak diizinkan dari status saat ini.');
            }
        }
    }
}
