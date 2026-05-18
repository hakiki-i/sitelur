@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <div class="mb-2">
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    {{-- Profile Info Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-user text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Informasi Profil</span>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Password Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-lock text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Ubah Password</span>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>



</div>
@endsection
