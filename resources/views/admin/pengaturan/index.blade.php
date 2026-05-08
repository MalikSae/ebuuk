@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola akun administrator')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-4xl">
    
    <!-- CARD KIRI — Info Akun -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="font-semibold text-slate-800">Informasi Akun</h2>
        </div>

        <div class="w-16 h-16 bg-teal-100 rounded-full mx-auto flex items-center justify-center font-bold text-xl text-teal-700">
            {{ substr($admin->name, 0, 1) }}
        </div>
        <p class="text-center font-semibold text-slate-800 mt-3">{{ $admin->name }}</p>
        <p class="text-center text-sm text-slate-500">{{ $admin->email }}</p>
        <div class="flex justify-center mt-2">
            <span class="bg-teal-50 text-teal-700 text-xs px-3 py-1 rounded-full">Administrator</span>
        </div>

        <div class="border-t border-slate-100 my-5"></div>

        <div class="divide-y divide-slate-50">
            <div class="py-3 flex justify-between items-center">
                <span class="text-slate-400 text-sm">Nama</span>
                <span class="text-slate-800 text-sm font-medium">{{ $admin->name }}</span>
            </div>
            <div class="py-3 flex justify-between items-center">
                <span class="text-slate-400 text-sm">Email</span>
                <span class="text-slate-800 text-sm font-medium">{{ $admin->email }}</span>
            </div>
        </div>
    </div>

    <!-- CARD KANAN — Ubah Password -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex flex-col mb-5">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <h2 class="font-semibold text-slate-800">Ubah Password</h2>
            </div>
            <p class="text-xs text-slate-400 mt-1">Minimal 8 karakter</p>
        </div>

        <!-- Flash messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm mb-5">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg px-4 py-3 text-sm mb-5">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.pengaturan.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Lama *</label>
                <input type="password" name="password_lama" required
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                @error('password_lama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru *</label>
                <input type="password" name="password_baru" required
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Minimal 8 karakter</p>
                @error('password_baru') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru *</label>
                <input type="password" name="password_baru_confirmation" required
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                @error('password_baru_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end mt-5 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
