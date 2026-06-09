{{-- File ini deprecated, gunakan auth/login.blade.php --}}
{{-- Redirect ke login baru --}}
@extends('auth.app')

@section('login')
<script>window.location.href = "{{ route('login') }}";</script>
@endsection