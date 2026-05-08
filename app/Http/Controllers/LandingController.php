<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $bukuTerbaru = Buku::with('kategori')
            ->orderByDesc('created_at')->limit(8)->get()
            ->map(fn($b) => [
                'id' => $b->id,
                'judul' => $b->judul,
                'slug' => $b->slug,
                'penulis' => $b->penulis,
                'cover_url' => $b->cover ? asset('images/covers/' . $b->cover) : null,
                'kategori' => $b->kategori?->nama,
            ]);

        $kategoris = Kategori::withCount('buku')
            ->orderByDesc('buku_count')->limit(8)->get()
            ->map(fn($k) => [
                'id' => $k->id,
                'nama' => $k->nama,
                'slug' => $k->slug,
                'icon' => $k->icon ?? 'book-open',
                'buku_count' => $k->buku_count,
            ]);

        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();

        return Inertia::render('Landing', [
            'bukuTerbaru' => $bukuTerbaru,
            'kategoris' => $kategoris,
            'totalBuku' => $totalBuku,
            'totalKategori' => $totalKategori,
        ]);
    }
}
