<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\RakBuku;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BukuPublikController extends Controller
{
    public function show(Buku $buku)
    {
        $diRak = false;
        if (auth()->check()) {
            $diRak = RakBuku::where('user_id', auth()->id())
                ->where('buku_id', $buku->id)->exists();
        }

        return Inertia::render('DetailBuku', [
            'buku' => [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'slug' => $buku->slug,
                'penulis' => $buku->penulis,
                'deskripsi' => $buku->deskripsi,
                'cover_url' => $buku->cover ? asset('images/covers/' . $buku->cover) : null,
                'kategori' => $buku->kategori?->nama,
                'kategori_slug' => $buku->kategori?->slug,
                'halaman' => $buku->halaman,
            ],
            'diRak' => $diRak,
            'sudahLogin' => auth()->check(),
        ]);
    }
}
