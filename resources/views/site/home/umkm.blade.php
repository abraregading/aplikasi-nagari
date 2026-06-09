@extends('site.konten.app')

@section('judul', 'Website ' . ($profilnagari['bentuk_pemerintahan'] ?? 'Desa') . ' ' . ($profilnagari['nama_pemerintahan'] ?? 'Digital'))

@section('sub_judul', 'Usaha Mikro, Kecil, dan Menengah (UMKM)')

@section('konten1')

<header class="page-header" style="background-image: url('{{asset('site')}}/assets/hero.png');">
        <h1>UMKM <br>{{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Digital' }}</h1>
</header>

@include('site.layouts.konten.umkm')

@endsection