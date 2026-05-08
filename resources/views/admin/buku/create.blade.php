@extends('layouts.admin')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="mb-5 text-sm text-slate-400">
    <a href="{{ route('admin.buku.index') }}" class="text-teal-600 hover:text-teal-700">Buku</a> › Tambah
</div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom kiri -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku *</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Masukkan judul buku"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
                    @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
                    @error('penulis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                    <select name="kategori_id" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Halaman</label>
                    <input type="number" name="halaman" value="{{ old('halaman') }}" min="1" placeholder="Contoh: 250"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">
                    @error('halaman') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Kolom kanan -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Cover Buku</label>
                    <div class="flex items-start gap-4">
                        <img id="cover-preview" src="{{ asset('images/cover-default.svg') }}"
                             class="w-24 h-32 object-cover rounded-xl border-2 border-slate-200 bg-slate-50">
                        <div>
                            <button type="button" onclick="document.getElementById('cover-input').click()" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                                Pilih Cover
                            </button>
                            <p class="text-xs text-slate-400 mt-2">JPG/PNG/WEBP maks 2MB</p>
                            <input type="file" name="cover" id="cover-input" accept="image/*" hidden>
                        </div>
                    </div>
                    @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">File PDF *</label>
                    <div id="pdf-drop-area" class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-teal-400 transition-colors cursor-pointer bg-slate-50">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-slate-500 mt-2">Klik untuk upload PDF</p>
                        <p class="text-xs text-slate-400 mt-1">PDF maksimal 50MB</p>
                        <p id="pdf-filename" class="text-xs text-teal-600 font-medium mt-2 hidden"></p>
                    </div>
                    <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" hidden required>
                    @error('file_pdf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- FULL WIDTH -->
        <div class="mt-4 mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
            <textarea name="deskripsi" rows="4" placeholder="Tulis sinopsis atau deskripsi singkat buku..."
                      class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder:text-slate-400">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan Buku
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Preview cover
document.getElementById('cover-input').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('cover-preview').src = e.target.result;
    reader.readAsDataURL(file);
  }
});
// PDF drop area click
document.getElementById('pdf-drop-area').addEventListener('click', () => {
  document.getElementById('file_pdf').click();
});
document.getElementById('file_pdf').addEventListener('change', function() {
  const filename = this.files[0]?.name;
  if (filename) {
    document.getElementById('pdf-filename').textContent = '✓ ' + filename;
    document.getElementById('pdf-filename').classList.remove('hidden');
    document.getElementById('pdf-drop-area').classList.add('border-teal-400');
  }
});
</script>
@endpush
@endsection
