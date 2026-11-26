@extends('layouts.frontend')

@push('title'){{ __('kelola PPID') }} - @endpush

@section('content')
    <div class="page-header-premium py-5 text-white position-relative overflow-hidden mb-0">
        <div class="page-header-pattern"></div>
        <div class="container py-4 position-relative z-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 text-white-50">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('Beranda') }}</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ __('kelola PPID') }}</li>
                </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-0">{{ __('kelola PPID') }}</h1>
        </div>
    </div>
    <section class="py-5 bg-white">
        <div class="container">
            <a href="{{ route('ppid.permohonan.create') }}">Buat Permohonan</a>
        </div>
    </section>
    <section class="py-5 bg-white">
        <div class="container">
            <a href="{{ route('ppid.permohonan.index') }}">Lihat Permohonan</a>
        </div>
    </section>
@endsection
