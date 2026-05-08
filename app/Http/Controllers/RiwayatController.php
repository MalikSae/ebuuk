<?php

namespace App\Http\Controllers;

use App\Models\RiwayatBaca;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatBaca::with('buku.kategori')
            ->where('user_id', auth()->id())
            ->orderByDesc('updated_at')->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'buku_id' => $r->buku_id,
                'judul' => $r->buku->judul,
                'slug' => $r->buku->slug,
                'penulis' => $r->buku->penulis,
                'cover_url' => $r->buku->cover ? asset('images/covers/' . $r->buku->cover) : null,
                'kategori' => $r->buku->kategori?->nama,
                'halaman_terakhir' => $r->halaman_terakhir,
                'halaman_total' => $r->buku->halaman,
                'updated_at' => $r->updated_at->format('d M Y'),
            ]);

        return Inertia::render('Riwayat', [
            'riwayat' => $riwayat,
        ]);
    }
}
