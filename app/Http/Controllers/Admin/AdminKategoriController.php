<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Str;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $search = request('search', '');
        $kategori = Kategori::withCount('buku')
            ->when($search, fn($q) => $q->where('nama', 'like', "%$search%"))
            ->orderBy('nama')->paginate(10)->withQueryString();
        return view('admin.kategori.index', compact('kategori', 'search'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama',
            'icon' => 'nullable|string'
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon ?? 'book-open',
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
            'icon' => 'nullable|string'
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon ?? 'book-open',
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::withCount('buku')->findOrFail($id);
        
        if ($kategori->buku_count > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki buku');
        }
        
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
