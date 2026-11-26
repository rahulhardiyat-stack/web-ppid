@extends('layouts.frontend') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Cek Status Permohonan Informasi - PPID')

@section('content')
    <div class="container py-5" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-search fs-3"></i>
                        </div>
                        <h3 class="fw-bold">Lacak Permohonan</h3>
                        <p class="text-muted">Masukkan Nomor Tiket dan Alamat Email Anda untuk melihat status permohonan informasi publik.</p>
                    </div>

                    {{-- Alert Error jika Nomor Tiket dan Email tidak cocok --}}
                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 shadow-sm d-flex align-items-center">
                            <i class="fas fa-exclamation-circle fs-4 me-3"></i>
                            <div>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    {{-- Form Pencarian --}}
                    <form method="POST" action="{{ route('frontend.ppid.permohonan.prosesCek') }}" novalidate>
                        @csrf

                        <div class="row g-4">

                            {{-- Input Nomor Tiket --}}
                            <div class="col-12">
                                <label for="no_tiket" class="form-label fw-semibold">Nomor Tiket <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="no_tiket"
                                       name="no_tiket"
                                       class="form-control form-control-lg rounded-3 @error('no_tiket') is-invalid @enderror"
                                       value="{{ old('no_tiket') }}"
                                       placeholder="Contoh: PPID-2023-000001"
                                       required>
                                @error('no_tiket')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Input Email --}}
                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="Email yang didaftarkan"
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cloudflare Turnstile (Anti-Bot) --}}
                            {{--<div class="col-12 text-center mt-2">
                                <div class="cf-turnstile d-inline-block" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                                @error('cf-turnstile-response')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>--}}

                            {{-- Tombol Submit --}}
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 shadow-sm">
                                    <i class="fas fa-search me-2"></i> Lacak Status Permohonan
                                </button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <a href="{{ route('frontend.ppid.permohonan.create') }}" class="text-decoration-none text-muted">
                                    Belum buat permohonan? <span class="text-primary fw-semibold">Buat di sini</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Turnstile (Jika Anda menggunakan Cloudflare Turnstile) --}}
    @push('scripts')
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endpush
@endsection
