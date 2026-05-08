@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . session('admin_name') . '! 👋')

@section('content')

<!-- GRID 4 STAT CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
    <!-- Card 1 — Total Buku -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Buku</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalBuku }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-teal-100 text-teal-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 2 — Total User -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total User</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalUser }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 3 — Total Kategori -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Kategori</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalKategori }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-amber-100 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 4 — Total Dibaca -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Dibaca</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalDibaca ?? 0 }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-purple-100 text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
    </div>

</div>

<!-- GRID 2 KOLOM -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    
    <!-- KOLOM KIRI — Buku Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between p-5 pb-0">
            <h2 class="font-semibold text-slate-800">Buku Terbaru</h2>
            <a href="{{ route('admin.buku.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium transition-colors">Lihat semua &rarr;</a>
        </div>
        
        <div class="px-5 pb-5 mt-2">
            @forelse($bukuTerbaru as $buku)
                <div class="flex items-center gap-3 py-3 border-b border-slate-50 last:border-0">
                    <img src="{{ $buku->cover_url }}" alt="Cover" class="w-10 h-14 object-cover rounded-lg border border-slate-200">
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $buku->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $buku->penulis ?? '-' }}</p>
                    </div>
                    <div class="ml-auto">
                        <span class="text-[11px] font-medium px-2.5 py-1 bg-teal-50 text-teal-700 rounded-full">
                            {{ $buku->kategori->nama ?? 'Tanpa Kategori' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-8">Belum ada buku</p>
            @endforelse
        </div>
    </div>

    <!-- KOLOM KANAN — User Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between p-5 pb-0">
            <h2 class="font-semibold text-slate-800">User Terbaru</h2>
            <a href="{{ route('admin.user.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium transition-colors">Lihat semua &rarr;</a>
        </div>
        
        <div class="px-5 pb-5 mt-2">
            @forelse($userTerbaru as $user)
                <div class="flex items-center gap-3 py-3 border-b border-slate-50 last:border-0">
                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-slate-600 font-semibold text-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</p>
                    </div>
                    <div class="ml-auto">
                        <p class="text-xs text-slate-400">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-8">Belum ada user</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
