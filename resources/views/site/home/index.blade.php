@extends('site.layouts.app')

@section('judul', 'Website ' . ($profilnagari['bentuk_pemerintahan'] ?? 'Desa') . ' ' . ($profilnagari['nama_pemerintahan'] ?? 'Digital'))

@section('sub_judul', 'Beranda')

@section('konten')

@include('site.layouts.partials.hero')
@include('site.layouts.konten.statistik')
@include('site.layouts.konten.profil')
@include('site.layouts.konten.layanan')
@include('site.layouts.konten.galeri')


@endsection