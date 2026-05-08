<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\RakBuku;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RakBukuController extends Controller
{
    public function index()
    {
        $rakBuku = RakBuku::with('buku.kategori')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'buku_id' => $r->buku_id,
                'judul' => $r->buku->judul,
                'slug' => $r->buku->slug,
                'penulis' => $r->buku->penulis,
                'cover_url' => $r->buku->cover ? asset('images/covers/' . $r->buku->cover) : null,
                'kategori' => $r->buku->kategori?->nama,
            ]);

        return Inertia::render('RakBuku', [
            'rakBuku' => $rakBuku,
        ]);
    }

    public function toggle(Buku $buku)
    {
        $existing = RakBuku::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Buku dihapus dari rak';
            $diRak = false;
        } else {
            RakBuku::create(['user_id' => auth()->id(), 'buku_id' => $buku->id]);
            $message = 'Buku ditambahkan ke rak';
            $diRak = true;
        }

        return back()->with(['message' => $message, 'diRak' => $diRak]);
    }
}
