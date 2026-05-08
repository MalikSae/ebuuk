@extends('layouts.admin')
@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="mb-5 text-sm text-slate-400">
    <a href="{{ route('admin.user.index') }}" class="text-teal-600 hover:text-teal-700">User</a> › {{ $user->name }}
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- KOLOM KIRI (col-span-1) -->
    <div class="col-span-1 space-y-6">
        <!-- Card info user -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="w-16 h-16 rounded-full bg-teal-100 flex items-center justify-center font-bold text-xl text-teal-700 mx-auto">
                {{ substr($user->name, 0, 1) }}
            </div>
            <p class="text-center font-semibold text-lg text-slate-800 mt-3">{{ $user->name }}</p>
            <p class="text-center text-sm text-slate-500">{{ $user->email }}</p>

            <div class="border-t border-slate-100 my-4"></div>

            <div class="flex justify-around mt-4">
                <div class="text-center">
                    <p class="font-bold text-slate-800">{{ $user->rak_buku_count }}</p>
                    <p class="text-xs text-slate-400">Rak Buku</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-slate-800">{{ $user->riwayat_baca_count }}</p>
                    <p class="text-xs text-slate-400">Dibaca</p>
                </div>
            </div>

            <p class="text-center text-xs text-slate-400 mt-4">
                Bergabung {{ $user->created_at->format('d F Y') }}
            </p>
        </div>
    </div>

    <!-- KOLOM KANAN (col-span-2) -->
    <div class="col-span-1 lg:col-span-2">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-slate-800 mb-4">Riwayat Bacaan</h2>

            <div class="divide-y divide-slate-50">
                @forelse($riwayat as $r)
                <div class="flex items-center gap-3 py-3">
                    @if($r->buku->cover)
                        <img src="{{ asset('images/covers/' . $r->buku->cover) }}" class="w-8 h-11 object-cover rounded bg-slate-50">
                    @else
                        <img src="{{ asset('images/cover-default.svg') }}" class="w-8 h-11 object-cover rounded bg-slate-100">
                    @endif
                    
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $r->buku->judul }}</p>
                        <p class="text-xs text-slate-400">Halaman {{ $r->halaman_terakhir }}</p>
                    </div>
                    
                    <p class="ml-auto text-xs text-slate-400">
                        {{ $r->updated_at->format('d M Y') }}
                    </p>
                </div>
                @empty
                <div class="py-6 text-center text-slate-400 text-sm">
                    Belum ada riwayat baca
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
