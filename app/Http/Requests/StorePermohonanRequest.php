<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermohonanRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Pre-process data sebelum divalidasi (Opsional).
     */
    protected function prepareForValidation(): void
    {
        // Contoh: menghapus spasi ekstra pada NIK dan No HP agar aman saat divalidasi
        $this->merge([
            'nik'   => preg_replace('/\D/', '', $this->nik),
            'no_hp' => preg_replace('/\s+|-/', '', $this->no_hp),
        ]);
    }

    /**
     * Aturan validasi form.
     */
    public function rules(): array
    {
        $nikBersih = $this->input('nik');
        $nikHash = hash('sha256', (string) $nikBersih);
        return [
            'nama'                  => ['required', 'string', 'max:150'],
            'nik'                   => ['required', 'digits:16'], // Dibuat required sesuai form
            'email'                 => ['required', 'email:rfc,dns', 'max:150'],
            'no_hp'                 => ['required', 'string', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'alamat'            => ['required', 'string', 'max:500'],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:150',
                function (string $attribute, mixed $value, Closure $fail) use ($nikHash) {
                    $existingPemohon = \App\Models\Pemohon::where('email', $value)->first();
                    // Jika email ada tapi NIK-nya beda, tolak inputannya
                    if ($existingPemohon && $existingPemohon->nik_hash !== $nikHash) {
                        $fail('Alamat email ini sudah terdaftar dan digunakan oleh NIK yang berbeda.');
                    }
                }
            ],
            'rincian_informasi'     => ['required', 'string', 'min:10', 'max:3000'],
            'tujuan'                => ['required', 'string', 'max:1000'],
            'cara_memperoleh'       => ['required', Rule::in(['melihat', 'salinan'])],

            // Wajib diisi JIKA cara memperoleh = salinan
            'cara_mendapat_salinan' => [
                'required_if:cara_memperoleh,salinan',
                'nullable',
                Rule::in(['diambil', 'pos', 'email'])
            ],

            // Nama input disesuaikan menjadi file_identitas
            'file_identitas'        => [
                'required',
                'file',
                'mimes:' . implode(',', config('ppid.upload.mimes', ['pdf', 'jpg', 'jpeg', 'png'])),
                'max:' . config('ppid.upload.max_kb', 2048)
            ],

            'persetujuan'           => ['accepted'], // Checkbox persetujuan wajib dicentang
            'website'               => ['prohibited'], // Honeypot trap: wajib kosong, jika terisi (oleh bot) maka gagal
            /*'cf-turnstile-response' => ['required', 'string'],*/ // Validasi Cloudflare Turnstile
        ];
    }

    /**
     * Pesan error kustom agar lebih ramah dibaca (Bahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'nik.digits'                     => 'NIK harus berupa 16 digit angka.',
            'no_hp.regex'                    => 'Format nomor HP tidak valid (gunakan awalan 08 / 628).',
            'cara_mendapat_salinan.required_if' => 'Metode penerimaan salinan wajib dipilih jika Anda meminta salinan.',
            'file_identitas.required'        => 'File identitas (KTP) wajib diunggah.',
            'file_identitas.mimes'           => 'Format identitas harus berupa PDF, JPG, atau PNG.',
            'file_identitas.max'             => 'Ukuran file identitas maksimal 2MB.',
            'persetujuan.accepted'           => 'Anda harus menyetujui penggunaan data pribadi.',
            /*'cf-turnstile-response.required' => 'Mohon verifikasi bahwa Anda bukan robot.',*/
            'website.prohibited'             => 'Aktivitas mencurigakan terdeteksi (Spam Bot).',
        ];
    }


}
