@extends('site.konten.app')

@section('judul', 'Website ' . ($profilnagari['bentuk_pemerintahan'] ?? 'Desa') . ' ' . ($profilnagari['nama_pemerintahan'] ?? 'Digital'))

@section('sub_judul', 'Pemerintahan')

@section('konten1') 

<header class="page-header" style="background-image: url('{{asset('site')}}/assets/hero.png');">
        <h1>Struktur Pemerintahan Nagari</h1>
</header>

<section class="container" style="padding-top: 0; max-width: 100%;">
    <div class="glass" style="padding: 3rem; border-radius: 20px; background: white; margin-top: -5rem; overflow-x: visible;">
        
        <p style="text-align: center; margin-bottom: 3rem; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
            Mengenal lebih dekat jajaran perangkat nagari yang siap <br>melayani masyarakat dengan integritas dan profesionalisme.
        </p>

        
        <!-- Desktop Tree View -->
        <div class="tree">
            <ul>
                <li>
                    <div class="org-card">
                        <img src="{{asset('site')}}/assets/staff/walinagari.jpg" alt="Kepala Desa">
                        <span class="name">{{ $walinagari->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $walinagari->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    <ul>
                        <li>
                            <div class="org-card">
                                <div style="width: 50px; height: 50px; background: #eee; border-radius: 50%; margin: 0 auto 0.3rem; display: flex; align-items: center; justify-content: center; border: 2px solid #f0f7f4; color: #ccc;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="name">{{ $sekdes->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                <span class="role">{{ $sekdes->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                            </div>
                            <ul>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kaur_keuangan->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kaur_keuangan->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                    @if($staf_kaur_keuangan->isNotEmpty())
                                    <ul>
                                        @foreach($staf_kaur_keuangan as $staf)
                                        <li>
                                            <div class="org-card org-card-staf">
                                                <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                                <span class="role">Staf {{ $kaur_keuangan->jabatan->nama_jabatan ?? '' }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kaur_umum->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kaur_umum->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                    @if($staf_kaur_umum->isNotEmpty())
                                    <ul>
                                        @foreach($staf_kaur_umum as $staf)
                                        <li>
                                            <div class="org-card org-card-staf">
                                                <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                                <span class="role">Staf {{ $kaur_umum->jabatan->nama_jabatan ?? '' }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                            </ul>
                        </li>

                        <li>
                            <div class="org-card">
                                <span class="name">{{ $kasipeme->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                <span class="role">{{ $kasipeme->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                            </div>
                            @if($staf_kasipeme->isNotEmpty())
                            <ul>
                                @foreach($staf_kasipeme as $staf)
                                <li>
                                    <div class="org-card org-card-staf">
                                        <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">Staf {{ $kasipeme->jabatan->nama_jabatan ?? '' }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        <li>
                            <div class="org-card">
                                <span class="name">{{ $kasi_kesra->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                <span class="role">{{ $kasi_kesra->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                            </div>
                            @if($staf_kasi_kesra->isNotEmpty())
                            <ul>
                                @foreach($staf_kasi_kesra as $staf)
                                <li>
                                    <div class="org-card org-card-staf">
                                        <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">Staf {{ $kasi_kesra->jabatan->nama_jabatan ?? '' }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>

                        <li>
                            <span class="group-label">Kewilayahan</span>
                            <div class="org-card" style="border-top-color: #999;">
                                <span class="name">Perangkat Wilayah</span>
                                <span class="role">Kepala Jorong</span>
                            </div>
                            <ul>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kepala_jorong_kuamang->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kepala_jorong_kuamang->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kepala_jorong_kuamangbarat->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kepala_jorong_kuamangbarat->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kepala_jorong_kuamangtimur->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kepala_jorong_kuamangtimur->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kepala_jorong_lubukalai->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kepala_jorong_lubukalai->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">{{ $kepala_jorong_lubukalaiselatan->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                                        <span class="role">{{ $kepala_jorong_lubukalaiselatan->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Mobile Card Layout -->
        <div class="mobile-org-cards" style="display: none;">
            <div class="mobile-leader-card">
                <img src="{{asset('site')}}/assets/staff/walinagari.jpg" alt="Wali Nagari">
                <span class="name">{{ $walinagari->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                <span class="role">{{ $walinagari->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
            </div>

            <div class="mobile-org-section">
                <h3><i class="fa-solid fa-user-tie"></i> Sekretariat</h3>
                <div class="mobile-staff-grid">
                    <div class="mobile-staff-card">
                        <div class="icon"><i class="fa-solid fa-user"></i></div>
                        <span class="name">{{ $sekdes->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $sekdes->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                </div>
                <div class="mobile-staff-grid" style="margin-top: 1rem;">
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kaur_keuangan->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kaur_keuangan->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    @if($staf_kaur_keuangan->isNotEmpty())
                        @foreach($staf_kaur_keuangan as $staf)
                        <div class="mobile-staff-card mobile-staff-card-staf">
                            <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                            <span class="role">Staf {{ $kaur_keuangan->jabatan->nama_jabatan ?? '' }}</span>
                        </div>
                        @endforeach
                    @endif
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kaur_umum->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kaur_umum->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    @if($staf_kaur_umum->isNotEmpty())
                        @foreach($staf_kaur_umum as $staf)
                        <div class="mobile-staff-card mobile-staff-card-staf">
                            <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                            <span class="role">Staf {{ $kaur_umum->jabatan->nama_jabatan ?? '' }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mobile-org-section">
                <h3><i class="fa-solid fa-users-gear"></i> Seksi-Seksi</h3>
                <div class="mobile-staff-grid">
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kasipeme->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kasipeme->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    @if($staf_kasipeme->isNotEmpty())
                        @foreach($staf_kasipeme as $staf)
                        <div class="mobile-staff-card mobile-staff-card-staf">
                            <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                            <span class="role">Staf {{ $kasipeme->jabatan->nama_jabatan ?? '' }}</span>
                        </div>
                        @endforeach
                    @endif
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kasi_kesra->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kasi_kesra->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    @if($staf_kasi_kesra->isNotEmpty())
                        @foreach($staf_kasi_kesra as $staf)
                        <div class="mobile-staff-card mobile-staff-card-staf">
                            <span class="name">{{ $staf->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                            <span class="role">Staf {{ $kasi_kesra->jabatan->nama_jabatan ?? '' }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mobile-org-section">
                <h3><i class="fa-solid fa-map-location-dot"></i> Kewilayahan (Kepala Jorong)</h3>
                <div class="mobile-kadus-grid">
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kepala_jorong_kuamang->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kepala_jorong_kuamang->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kepala_jorong_kuamangbarat->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kepala_jorong_kuamangbarat->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kepala_jorong_kuamangtimur->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kepala_jorong_kuamangtimur->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kepala_jorong_lubukalai->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kepala_jorong_lubukalai->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                    <div class="mobile-staff-card">
                        <span class="name">{{ $kepala_jorong_lubukalaiselatan->penduduk->nama_lengkap ?? 'Nama Tidak Diketahui' }}</span>
                        <span class="role">{{ $kepala_jorong_lubukalaiselatan->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    .org-card-staf {
        border-top-color: #a8d5ba !important;
        opacity: 0.9;
    }
    .org-card-staf .name {
        font-size: 0.8rem !important;
    }
    .org-card-staf .role {
        font-size: 0.7rem !important;
    }
    .mobile-staff-card-staf {
        border-left: 3px solid #a8d5ba !important;
        background: rgba(168, 213, 186, 0.05) !important;
    }
    .mobile-staff-card-staf .name {
        font-size: 0.85rem !important;
    }
    .mobile-staff-card-staf .role {
        font-size: 0.7rem !important;
    }
</style>

@endsection
