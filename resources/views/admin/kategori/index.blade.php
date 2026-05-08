@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'Kelola kategori buku')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
    <!-- Kiri: Search bar -->
    <form action="{{ route('admin.kategori.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori..." 
               class="w-full sm:w-64 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
            Cari
        </button>
    </form>

    <!-- Kanan: Tombol Tambah -->
    <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap w-full sm:w-auto">
        + Tambah Kategori
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
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Icon</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Slug</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Jumlah Buku</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-50">
      @forelse($kategori as $index => $item)
      <tr class="hover:bg-slate-50/50 transition-colors">
        <td class="px-5 py-4 text-sm text-slate-700">{{ $kategori->firstItem() + $index }}</td>
        <td class="px-5 py-4 text-sm text-slate-500">
            <x-dynamic-icon name="{{ $item->icon }}" class="w-5 h-5 text-teal-600" />
        </td>
        <td class="px-5 py-4 text-sm font-medium text-slate-800">{{ $item->nama }}</td>
        <td class="px-5 py-4 text-sm font-mono text-xs text-slate-400">{{ $item->slug }}</td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <span class="bg-teal-50 text-teal-700 text-xs px-2 py-1 rounded-full">{{ $item->buku_count }}</span>
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.kategori.edit', $item->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-teal-600 text-sm font-medium rounded-lg hover:bg-teal-50 transition-colors">
                    Edit
                </a>
                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?');">
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
          Belum ada kategori
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
    {{ $kategori->links() }}
</div>
@endsection
