<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\RiwayatBaca;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function show(Buku $buku)
    {
        $riwayat = RiwayatBaca::firstOrCreate(
            ['user_id' => auth()->id(), 'buku_id' => $buku->id],
            ['halaman_terakhir' => 1]
        );

        return Inertia::render('Reader', [
            'buku' => [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'slug' => $buku->slug,
                'penulis' => $buku->penulis,
                'cover_url' => $buku->cover ? asset('images/covers/' . $buku->cover) : null,
                'halaman' => $buku->halaman,
            ],
            'halamanTerakhir' => $riwayat->halaman_terakhir,
            'streamUrl' => route('reader.stream', $buku->slug),
        ]);
    }

    public function stream(Buku $buku)
    {
        $path = storage_path('app/private/ebooks/' . $buku->file_pdf);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $buku->slug . '.pdf"',
            'Cache-Control' => 'no-store, no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function saveProgress(Request $request, Buku $buku)
    {
        $request->validate(['halaman' => 'required|integer|min:1']);

        RiwayatBaca::updateOrCreate(
            ['user_id' => auth()->id(), 'buku_id' => $buku->id],
            ['halaman_terakhir' => $request->halaman]
        );

        return back();
    }
}
