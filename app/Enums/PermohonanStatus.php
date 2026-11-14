<?php
namespace App\Enums;

enum PermohonanStatus: string
{
    case DITERIMA = 'diterima';
    case DIPROSES = 'diproses';
    case SELESAI = 'selesai';
    case TOLAK = 'ditolak';
}

