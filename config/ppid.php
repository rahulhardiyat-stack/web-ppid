<?php

return [
    'prefix_permohonan' => 'PPID',
    'prefix_keberatan'  => 'KBR',
    'email_admin'       => env('PPID_EMAIL_ADMIN'),
    'batas_jawab_hari_kerja'      => 10,
    'perpanjangan_hari_kerja'     => 7,
    'batas_ajukan_keberatan_hari' => 30,
    'batas_jawab_keberatan_hari'  => 30,
    'upload' => ['max_kb' => 2048, 'mimes' => ['pdf', 'jpg', 'jpeg', 'png']],
    // Alasan keberatan (Pasal 35 UU KIP), verifikasi ke teks resmi
    'alasan_keberatan' => [
        'penolakan'          => 'Penolakan permintaan informasi berdasarkan alasan pengecualian',
        'informasi_berkala'  => 'Tidak disediakannya informasi berkala',
        'tidak_ditanggapi'   => 'Permintaan informasi tidak ditanggapi',
        'tidak_sesuai'       => 'Permintaan ditanggapi tidak sebagaimana yang diminta',
        'tidak_dipenuhi'     => 'Permintaan informasi tidak dipenuhi',
        'biaya_tidak_wajar'  => 'Pengenaan biaya yang tidak wajar',
        'melebihi_waktu'     => 'Penyampaian informasi melebihi waktu yang diatur',
    ],
];
