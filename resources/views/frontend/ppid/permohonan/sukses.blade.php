@extends('layouts.frontend')

@push('title')
    {{ __('Permohonan Berhasil') }} -
@endpush

@section('content')
    <div class="container py-5" data-aos="zoom-in">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">

                <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">

                    {{-- Ikon Sukses Animasi Sederhana --}}
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="fas fa-check fs-1"></i>
                        </div>
                    </div>

                    <h3 class="fw-bold text-success mb-3">Permohonan Berhasil Dikirim!</h3>
                    <p class="text-muted mb-4">Terima kasih, permohonan informasi publik Anda telah kami terima dan akan segera diproses oleh tim PPID.</p>

                    {{-- Kotak Nomor Tiket --}}
                    <div class="bg-light border rounded-3 p-4 mb-4">
                        <small class="text-muted d-block mb-2">Nomor Tiket Anda:</small>
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            {{-- user-select-all memudahkan user meng-copy tiket hanya dengan 1x klik --}}
                            <h2 class="fw-bold text-primary mb-0 user-select-all" id="textNomorTiket" style="letter-spacing: 1px;">
                                {{ $noTiket }}
                            </h2>

                            {{-- Tombol Salin --}}
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" id="btnCopyTiket" onclick="copyTiket()">
                                <i class="fas fa-copy me-1"></i> Salin
                            </button>
                        </div>
                    </div>

                    {{-- Peringatan Simpan Tiket --}}
                    <div class="alert alert-warning border-0 rounded-3 text-start fs-6 shadow-sm mb-4">
                        <i class="fas fa-info-circle me-2 text-warning fs-5 float-start mt-1"></i>
                        <div class="ms-4">
                            <strong>Penting:</strong> Harap simpan atau <em>copy</em> Nomor Tiket di atas. Anda akan membutuhkannya beserta alamat Email Anda untuk melacak status permohonan.
                        </div>
                    </div>

                    {{--Tombol Aksi --}}
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-2">
                        <a href="{{ url('#') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            <i class="fas fa-home me-2"></i> Beranda
                        </a>
                        <a href="{{ route('ppid.permohonan.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                            <i class="fas fa-search me-2"></i> Lacak Status
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyTiket() {
            // Ambil elemen teks dan tombol
            const textTiket = document.getElementById('textNomorTiket').innerText.trim();
            const btnCopy = document.getElementById('btnCopyTiket');

            // Simpan HTML asli tombol untuk dikembalikan nanti
            const originalHtml = btnCopy.innerHTML;

            // Gunakan Clipboard API modern
            navigator.clipboard.writeText(textTiket).then(() => {
                // Ubah tampilan tombol menjadi status "Berhasil/Tersalin"
                btnCopy.innerHTML = '<i class="fas fa-check me-1"></i> Tersalin!';
                btnCopy.classList.remove('btn-outline-primary');
                btnCopy.classList.add('btn-success', 'text-white');

                // Kembalikan ke tampilan semula setelah 2 detik
                setTimeout(() => {
                    btnCopy.innerHTML = originalHtml;
                    btnCopy.classList.remove('btn-success', 'text-white');
                    btnCopy.classList.add('btn-outline-primary');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
                alert('Browser Anda tidak mendukung fitur copy otomatis. Silakan blok teks dan copy secara manual.');
            });
        }
    </script>
@endpush
