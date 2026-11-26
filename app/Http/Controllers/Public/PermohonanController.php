<?php

namespace App\Http\Controllers\Public;

use App\Actions\BuatPermohonan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermohonanRequest;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function create()
    {
        return view('frontend.ppid.permohonan.create');
    }

    public function store(StorePermohonanRequest $request, BuatPermohonan $action)
    {
        // Ubah 'identitas' menjadi 'file_identitas' di except() dan di file()
        $permohonan = $action->handle(
            $request->safe()->except(['file_identitas', 'persetujuan', 'website']),
            $request->file('file_identitas')
        );

        // simpan tiket di session flash supaya halaman sukses tidak bisa dibuka sembarangan
        return redirect()
            ->route('ppid.permohonan.sukses') // Sesuaikan dengan nama route Anda, biasanya ada prefixnya
            ->with('no_tiket', $permohonan->no_tiket);
    }

    public function sukses()
    {
        abort_unless(session()->has('no_tiket'), 404, 'Halaman tidak ditemukan atau sesi Anda telah berakhir.');

        return view('frontend.ppid.permohonan.sukses', ['noTiket' => session('no_tiket')]);
    }
}
