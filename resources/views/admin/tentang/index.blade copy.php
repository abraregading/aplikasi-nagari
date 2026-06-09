@extends('admin.layouts.app')

@section('title', 'Tentang Nagari')

@section('head')
<style>
        .form-section-title {
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            color: var(--primary);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding-bottom: 0.5rem;
        }
        
        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }
        .checkbox-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--text-muted);
            border-radius: 6px;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
        }
        .checkbox-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .checkbox-input:checked::after {
            content: '\eb7b'; /* Remix Icon Check */
            font-family: 'remixicon';
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
        }

        /* Custom Radio */
        .radio-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }
        .radio-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--text-muted);
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
        }
        .radio-input:checked {
            border-color: var(--primary);
        }
        .radio-input:checked::after {
            content: '';
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--text-muted);
            transition: .4s;
            border-radius: 24px;
            opacity: 0.5;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: var(--primary);
            opacity: 1;
        }
        input:checked + .slider:before {
            transform: translateX(24px);
        }
        
    </style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Tentang {{ $profil['bentuk_pemerintahan'] ?? 'Desa' }}</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
    
    <!-- Basic Inputs -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Identitas {{ $profil['bentuk_pemerintahan'] ?? 'Desa' }}</h3>
        <form method="POST" action="{{ route('tentang.update', 1) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['bentuk_pemerintahan'] }}</label>
                <textarea name="bentuk_pemerintahan" class="glass-select" rows="4" style="width:100%; height:auto;" placeholder="Write a message...">{{ $profil['bentuk_pemerintahan'] ?? '' }}</textarea>
            </div>
    </div>

    <!-- Selection & Toggles -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Alamat</h3>
        
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['alamat'] }}</label>
            <input type="text" name="alamat" value="{{ $profil['alamat'] ?? '' }}" placeholder="Isikan Alamat Nagari" class="glass-select" style="width:100%;">
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['provinsi'] }}</label>
            <input type="text" name="provinsi" value="{{ $profil['provinsi'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['kabupaten'] }}</label>
            <input type="text" name="kabupaten" value="{{ $profil['kabupaten'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['kecamatan'] }}</label>
            <input type="text" name="kecamatan" value="{{ $profil['kecamatan'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['titikkoordinat'] }}</label>
            <input type="text" name="titikkoordinat" value="{{ $profil['titikkoordinat'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>
        
    </div>

    <!-- Advanced & Buttons -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Kontak Kami</h3>
        
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['no_hp'] }}</label>
            <input type="text" name="no_hp" value="{{ $profil['no_hp'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">{{ $fields['email'] }}</label>
            <input type="email" name="email" value="{{ $profil['email'] ?? '' }}" class="glass-select" style="width:100%;">
        </div>

    <div style="margin-top: 2rem; text-align: right; grid-column: 1/-1;">
        <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">Update</button>
    </div>
    @if(session('success'))
        <div style="margin-top: 1rem; color: green;">{{ session('success') }}</div>
    @endif
    </form>

                
    </div>

</div>
@endsection