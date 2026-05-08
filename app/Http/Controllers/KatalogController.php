<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Inertia\Inertia;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $search = request('search', '');
        $kategoriSlug = request('kategori', '');

        $buku = Buku::with('kategori')
            ->when($search, fn($q) => $q
                ->where('judul', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%"))
            ->when($kategoriSlug, fn($q) => $q
                ->whereHas('kategori', fn($q) => $q->where('slug', $kategoriSlug)))
            ->orderByDesc('created_at')
            ->paginate(12)->withQueryString();

        $kategoris = Kategori::withCount('buku')->orderBy('nama')->get()
            ->map(fn($k) => [
                'id' => $k->id,
                'nama' => $k->nama,
                'slug' => $k->slug,
                'icon' => $k->icon ?? 'book-open',
                'buku_count' => $k->buku_count,
            ]);

        return Inertia::render('Katalog', [
            'buku' => $buku->through(fn($b) => [
                'id' => $b->id,
                'judul' => $b->judul,
                'slug' => $b->slug,
                'penulis' => $b->penulis,
                'cover_url' => $b->cover ? asset('images/covers/' . $b->cover) : null,
                'kategori' => $b->kategori?->nama,
                'kategori_slug' => $b->kategori?->slug,
            ]),
            'kategoris' => $kategoris,
            'filters' => [
                'search' => $search,
                'kategori' => $kategoriSlug,
            ],
        ]);
    }
}
