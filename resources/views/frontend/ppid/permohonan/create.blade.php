@extends('layouts.frontend')

@push('title')
    {{ __('Permohonan') }} -
@endpush

@section('content')
    <div class="page-header-premium py-5 text-white position-relative overflow-hidden">
        <div class="page-header-pattern"></div>
        <div class="container py-4 position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2 text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Hubungi Kami') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-0">{{ __('Permohonan') }}</h1>
                    <p class="lead mb-0 text-white-50 mt-2">{{ __('Kami siap melayani permohonan informasi dari Anda.') }}</p>
                </div>
            </div>
        </div>
        <div class="page-header-logo">
            @php $logo = \App\Models\Setting::get('site_logo') @endphp
            @if($logo)
                <img src="{{ asset('storage/'.$logo) }}" alt="Logo">
            @endif
        </div>
    </div>
    <section class="py-0 bg-light">
        <div class="container" >
            <div class="row g-5">
                <!-- Permohonan Form -->
                <div class="container" data-aos="fade-left">
                    {{-- Membatasi lebar form agar tidak terlalu memanjang di layar besar --}}
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">

                            <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                                <h3 class="fw-bold mb-4 text-center text-bold">{{ __('FORM PERMOHONAN INFORMASI') }}</h3>

                                {{-- Alert Success --}}
                                @if(session('success'))
                                    <div class="alert alert-success border-0 rounded-4 p-3 mb-4 shadow-sm">
                                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('ppid.permohonan.store') }}" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="row g-4">
                                        {{-- ================= BAGIAN 1: DATA PEMOHON ================= --}}
                                        <div class="col-12 mb-0 mt-24">
                                            <h5 class="fw-bold text-success text-center border-bottom pb-2">Identitas Pemohon</h5>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" id="nama" name="nama" class="form-control rounded-3 py-2 @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nik" class="form-label fw-semibold">NIK KTP <span class="text-danger">*</span></label>
                                            <input type="number" id="nik" name="nik" class="form-control rounded-3 py-2 @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required placeholder="16 digit angka">
                                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email@contoh.com">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="no_hp" class="form-label fw-semibold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                            <input type="number" id="no_hp" name="no_hp" class="form-control rounded-3 py-2 @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx">
                                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea id="alamat" name="alamat" rows="2" class="form-control rounded-3 py-2 @error('alamat') is-invalid @enderror" required placeholder="Sesuai KTP/Domisili">{{ old('alamat') }}</textarea>
                                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="file_identitas" class="form-label fw-semibold">Unggah Identitas (KTP) <span class="text-danger">*</span></label>
                                            <input type="file" id="file_identitas" name="file_identitas" class="form-control rounded-3 py-2 @error('file_identitas') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <div class="form-text text-muted">Format: PDF, JPG, PNG. Max 2MB.</div>
                                            @error('file_identitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>


                                        {{-- ================= BAGIAN 2: DETAIL PERMOHONAN ================= --}}
                                        <div class="col-12 mt-5 mb-0">
                                            <h5 class="fw-bold text-success text-center border-bottom pb-2">Detail Permohonan</h5>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="rincian_informasi" class="form-label fw-semibold">Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span></label>
                                            <textarea id="rincian_informasi" name="rincian_informasi" rows="3" class="form-control rounded-3 py-2 @error('rincian_informasi') is-invalid @enderror" required placeholder="Jelaskan secara detail informasi apa yang Anda butuhkan...">{{ old('rincian_informasi') }}</textarea>
                                            @error('rincian_informasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="tujuan" class="form-label fw-semibold">Tujuan Penggunaan Informasi <span class="text-danger">*</span></label>
                                            <textarea id="tujuan" name="tujuan" rows="2" class="form-control rounded-3 py-2 @error('tujuan') is-invalid @enderror" required placeholder="Jelaskan untuk apa informasi ini akan digunakan...">{{ old('tujuan') }}</textarea>
                                            @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold d-block">Cara Memperoleh Informasi <span class="text-danger">*</span></label>
                                            <div class="d-flex flex-column gap-2 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="cara_memperoleh" id="cara_melihat" value="melihat" @checked(old('cara_memperoleh') === 'melihat') required>
                                                    <label class="form-check-label" for="cara_melihat">Melihat / Membaca</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="cara_memperoleh" id="cara_salinan" value="salinan" @checked(old('cara_memperoleh') === 'salinan') required>
                                                    <label class="form-check-label" for="cara_salinan">Mendapat Salinan</label>
                                                </div>
                                            </div>
                                            @error('cara_memperoleh') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-6" id="blok-salinan" style="{{ old('cara_memperoleh') === 'salinan' ? '' : 'display: none;' }}">
                                            <label for="cara_mendapat_salinan" class="form-label fw-semibold">Metode Penerimaan Salinan <span class="text-danger">*</span></label>
                                            <select class="form-select rounded-3 py-2 @error('cara_mendapat_salinan') is-invalid @enderror" id="cara_mendapat_salinan" name="cara_mendapat_salinan">
                                                <option value="" disabled selected>-- Pilih Metode --</option>
                                                <option value="diambil" @selected(old('cara_mendapat_salinan') == 'diambil')>Diambil Langsung</option>
                                                <option value="pos" @selected(old('cara_mendapat_salinan') == 'pos')>Melalui Pos</option>
                                                <option value="email" @selected(old('cara_mendapat_salinan') == 'email')>Melalui Email</option>
                                            </select>
                                            @error('cara_mendapat_salinan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        {{-- Keamanan & Persetujuan --}}
                                        <div class="col-md-12 mt-4">
                                            {{-- Honeypot --}}
                                            <div style="position:absolute; left:-9999px" aria-hidden="true">
                                                <input type="text" name="website" tabindex="-1" autocomplete="off">
                                            </div>

                                            {{-- Turnstile --}}
                                            <div class="cf-turnstile mb-3" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                                            @error('cf-turnstile-response')
                                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                                            @enderror

                                            <div class="form-check p-3 bg-light rounded-3 border">
                                                <input class="form-check-input ms-1 mt-1 @error('persetujuan') is-invalid @enderror" type="checkbox" id="persetujuan" name="persetujuan" value="1" @checked(old('persetujuan')) required>
                                                <label class="form-check-label ms-2" for="persetujuan">
                                                    Saya menyatakan bahwa data yang diisi adalah benar, dan menyetujui penggunaan data pribadi untuk keperluan layanan informasi publik.
                                                </label>
                                                @error('persetujuan') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="col-md-12 mt-4 text-center">
                                            <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm w-100 w-md-auto">
                                                <i class="fas fa-paper-plane me-2"></i> Kirim Permohonan
                                            </button>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const radioMelihat = document.getElementById('cara_melihat');
                        const radioSalinan = document.getElementById('cara_salinan');
                        const blokSalinan = document.getElementById('blok-salinan');
                        const selectCaraMendapat = document.getElementById('cara_mendapat_salinan');

                        function toggleSalinanBlock() {
                            if (radioSalinan.checked) {
                                blokSalinan.style.display = 'block';
                                selectCaraMendapat.setAttribute('required', 'required');
                            } else {
                                blokSalinan.style.display = 'none';
                                selectCaraMendapat.removeAttribute('required');
                                selectCaraMendapat.value = "";
                            }
                        }

                        toggleSalinanBlock();
                        radioMelihat.addEventListener('change', toggleSalinanBlock);
                        radioSalinan.addEventListener('change', toggleSalinanBlock);
                    });
                </script>
                @endsection


                @push('scripts')
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                    <script>
                        // interaksi ringan tanpa framework
                        const radios = document.querySelectorAll('input[name="cara_memperoleh"]');
                        const blok = document.getElementById('blok-salinan');
                        const toggle = () => { blok.hidden = document.querySelector('input[name="cara_memperoleh"]:checked')?.value !== 'salinan'; };
                        radios.forEach(r => r.addEventListener('change', toggle));
                        toggle();

                        // cegah klik ganda saat kirim
                        document.querySelector('form').addEventListener('submit', e => {
                            e.target.querySelector('[type=submit]').disabled = true;
                        });
                    </script>
                @endpush



                @push('styles')
                    <style>
                        .rotate-n-15 { transform: rotate(-15deg); }
                        .bg-primary-subtle { background-color: rgba(12, 121, 14, 0.1); }
                        .form-control:focus {
                            border-color: var(--bs-primary);
                            box-shadow: 0 0 0 0.25rem rgba(12, 121, 14, 0.1);
                        }
                    </style>
    @endpush
