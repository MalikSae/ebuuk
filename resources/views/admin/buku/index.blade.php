@extends('layouts.admin')
@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')
@section('page-subtitle', 'Kelola koleksi ebook')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
    <!-- Kiri: Search bar -->
    <form action="{{ route('admin.buku.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul/penulis..." 
               class="w-full sm:w-64 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
            Cari
        </button>
    </form>

    <!-- Kanan: Tombol Tambah -->
    <a href="{{ route('admin.buku.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap w-full sm:w-auto">
        + Tambah Buku
    </a>
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

<!-- Tabel -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-x-auto">
  <table class="w-full whitespace-nowrap">
    <thead class="bg-slate-50 border-b border-slate-100">
      <tr>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Cover</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Judul & Penulis</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Kategori</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Halaman</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-50">
      @forelse($buku as $index => $item)
      <tr class="hover:bg-slate-50/50 transition-colors">
        <td class="px-5 py-4 text-sm text-slate-700">{{ $buku->firstItem() + $index }}</td>
        <td class="px-5 py-4 text-sm text-slate-700">
            @if($item->cover)
                <img src="{{ asset('images/covers/' . $item->cover) }}" class="w-9 h-12 object-cover rounded-lg">
            @else
                <img src="{{ asset('images/cover-default.svg') }}" class="w-9 h-12 object-cover rounded-lg bg-slate-100">
            @endif
        </td>
        <td class="px-5 py-4">
            <p class="font-medium text-slate-800">{{ $item->judul }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $item->penulis ?? '-' }}</p>
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            @if($item->kategori)
                <span class="bg-teal-50 text-teal-700 text-xs px-2 py-1 rounded-full">{{ $item->kategori->nama }}</span>
            @else
                <span class="bg-slate-50 text-slate-500 text-xs px-2 py-1 rounded-full">Tanpa Kategori</span>
            @endif
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            {{ $item->halaman ? $item->halaman . ' hal' : '-' }}
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.buku.edit', $item->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-teal-600 text-sm font-medium rounded-lg hover:bg-teal-50 transition-colors">
                    Edit
                </a>
                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 text-red-500 text-sm font-medium rounded-lg hover:bg-red-50 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="px-5 py-12 text-center text-slate-400 text-sm">
          Belum ada buku
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
    {{ $buku->links() }}
</div>
@endsection
