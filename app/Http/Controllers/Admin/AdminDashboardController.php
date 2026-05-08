<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalUser = User::count();
        $totalKategori = Kategori::count();
        $totalDibaca = \App\Models\RiwayatBaca::count();
        
        $bukuTerbaru = Buku::with('kategori')->orderByDesc('created_at')->limit(5)->get();
        $userTerbaru = User::orderByDesc('created_at')->limit(5)->get();
        
        return view('admin.dashboard', compact('totalBuku', 'totalUser', 'totalKategori', 'totalDibaca', 'bukuTerbaru', 'userTerbaru'));
    }
}
