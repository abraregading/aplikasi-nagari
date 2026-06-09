@extends('admin.layouts.app')

@section('title', 'Dashboard Tambah Kategori Projek')

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
<h2 style="margin-bottom: 2rem;">Tambah Kategori Projek</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
    
    <!-- Basic Inputs -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Tambah Kategori Projek</h3>

    <form method="POST" action="{{ route('kategori-projek.store') }}">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="glass-select" style="width:100%;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Deskripsi</label>
            <textarea class="glass-select" rows="4" style="width:100%; height:auto;" name="deskripsi" placeholder="Write a message...">{{ old('deskripsi') }}</textarea>
        </div>
                
        
        
        <div style="margin-top: 2rem; text-align: right; grid-column: 1/-1;">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">Simpan</button>
        </div>
                    
        </div>
    </form>

</div>
@endsection