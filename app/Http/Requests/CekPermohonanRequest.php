<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CekPermohonanRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true; // Form ini bersifat publik (tidak perlu login)
    }

    /**
     * Aturan validasi form.
     */
    public function rules(): array
    {
        return [
            'no_tiket'              => ['required', 'string', 'max:30'],
            'email'                 => ['required', 'email:rfc,dns', 'max:150'],
            /* 'cf-turnstile-response' => ['required', 'string'],*/ // Validasi Cloudflare Turnstile
        ];
    }

    /**
     * Pesan error kustom (Bahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'no_tiket.required'              => 'Nomor tiket wajib diisi.',
            'no_tiket.max'                   => 'Format nomor tiket tidak valid (maksimal 30 karakter).',
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            /*'cf-turnstile-response.required' => 'Mohon verifikasi bahwa Anda bukan robot.',*/
        ];
    }

    /**
     * Pre-process / Membersihkan input sebelum divalidasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('no_tiket')) {
            $this->merge([
                // Menghapus spasi yang mungkin tidak sengaja ter-copy oleh user (contoh: " PPID-2023-001 ")
                'no_tiket' => trim($this->no_tiket),
            ]);
        }

        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim($this->email)),
            ]);
        }
    }
}
