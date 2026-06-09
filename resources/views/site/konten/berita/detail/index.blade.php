@extends('site.konten.app')

@section('judul', 'Berita Desa - Desa Digital')

@php
$hari = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
$bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$dayOfWeek = $berita->created_at->dayOfWeekIso;
$month = $berita->created_at->month;
$namaHari = $hari[$dayOfWeek];
$namaBulan = $bulan[$month];
@endphp

@section('konten1') 

<header class="article-header" style="background-image: url('{{asset('site')}}/assets/news/dana.png');">
    <div class="article-title-wrapper">
        <div class="article-meta">
            <span><i class="fa-regular fa-calendar"></i> {{ $namaHari }}, {{ $berita->created_at->day }} {{ $namaBulan }} {{ $berita->created_at->year }}</span>
            <span><i class="fa-regular fa-user"></i> Penulis: Admin {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }}</span>
            <span><i class="fa-regular fa-eye"></i> {{ $berita->views }}x Dilihat</span>
        </div>
        <h1>{{ $berita->judul_berita }}</h1>
    </div>
</header>

<div class="container article-layout">
    <!-- Main Content -->
    @include('site.konten.berita.detail.detail-berita-main')

    <!-- Sidebar -->
    @include('site.konten.berita.detail.detail-berita-sidebar')
</div>

<!-- Komentar Section -->
    
@endsection()