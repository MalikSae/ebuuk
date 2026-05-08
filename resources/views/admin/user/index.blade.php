@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Daftar pengguna terdaftar')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
    <!-- Kiri: Search -->
    <form action="{{ route('admin.user.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama/email..." 
               class="w-full sm:w-64 border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
            Cari
        </button>
    </form>

    <!-- Kanan: Counter -->
    <div class="bg-slate-100 text-slate-600 text-sm font-medium px-4 py-2.5 rounded-lg border border-slate-200 w-full sm:w-auto text-center">
        Total: {{ $users->total() }} User
    </div>
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
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">User</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Rak Buku</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Riwayat Baca</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Bergabung</th>
        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-50">
      @forelse($users as $index => $user)
      <tr class="hover:bg-slate-50/50 transition-colors">
        <td class="px-5 py-4 text-sm text-slate-700">{{ $users->firstItem() + $index }}</td>
        <td class="px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <p class="font-medium text-slate-800">{{ $user->name }}</p>
            </div>
        </td>
        <td class="px-5 py-4 text-sm text-slate-500">{{ $user->email }}</td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <span class="bg-teal-50 text-teal-700 text-xs px-2 py-1 rounded-full">{{ $user->rak_buku_count }} buku</span>
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $user->riwayat_baca_count }} buku</span>
        </td>
        <td class="px-5 py-4 text-sm text-slate-500">
            {{ $user->created_at->format('d M Y') }}
        </td>
        <td class="px-5 py-4 text-sm text-slate-700">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.user.show', $user->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-teal-600 text-sm font-medium rounded-lg hover:bg-teal-50 transition-colors">
                    Detail
                </a>
                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Semua data terkait (rak buku, riwayat) akan ikut terhapus.');">
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
        <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">
          Belum ada user terdaftar
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
