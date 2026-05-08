<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Str;

class AdminBukuController extends Controller
{
    public function index()
    {
        $search = request('search', '');
        $buku = Buku::with('kategori')
            ->when($search, fn($q) => $q
                ->where('judul', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%"))
            ->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('admin.buku.index', compact('buku', 'search'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'nullable|exists:kategori,id',
            'halaman' => 'nullable|integer|min:1',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_pdf' => 'required|mimes:pdf|max:51200'
        ]);

        $coverNama = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverNama = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/covers'), $coverNama);
        }

        $pdfNama = time() . '_' . Str::slug($request->judul) . '.pdf';
        $request->file('file_pdf')->move(storage_path('app/private/ebooks'), $pdfNama);

        $slug = Buku::generateSlug($request->judul);

        Buku::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'penulis' => $request->penulis,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
            'halaman' => $request->halaman,
            'cover' => $coverNama,
            'file_pdf' => $pdfNama,
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'nullable|exists:kategori,id',
            'halaman' => 'nullable|integer|min:1',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:51200'
        ]);

        if ($request->hasFile('cover')) {
            if ($buku->cover && file_exists(public_path('images/covers/' . $buku->cover))) {
                unlink(public_path('images/covers/' . $buku->cover));
            }
            $file = $request->file('cover');
            $coverNama = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/covers'), $coverNama);
            $buku->cover = $coverNama;
        }

        if ($request->hasFile('file_pdf')) {
            $oldPath = storage_path('app/private/ebooks/' . $buku->file_pdf);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $pdfNama = time() . '_' . Str::slug($request->judul) . '.pdf';
            $request->file('file_pdf')->move(storage_path('app/private/ebooks'), $pdfNama);
            $buku->file_pdf = $pdfNama;
        }

        if ($buku->judul !== $request->judul) {
            $buku->slug = Buku::generateSlug($request->judul, $buku->id);
        }

        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->deskripsi = $request->deskripsi;
        $buku->kategori_id = $request->kategori_id;
        $buku->halaman = $request->halaman;
        $buku->save();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        
        if ($buku->cover && file_exists(public_path('images/covers/' . $buku->cover))) {
            unlink(public_path('images/covers/' . $buku->cover));
        }
        
        $pdfPath = storage_path('app/private/ebooks/' . $buku->file_pdf);
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
        
        $buku->delete();
        
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
