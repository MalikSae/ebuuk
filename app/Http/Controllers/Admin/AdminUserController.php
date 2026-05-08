<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $search = request('search', '');
        $users = User::withCount(['rakBuku', 'riwayatBaca'])
            ->when($search, fn($q) => $q
                ->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
            ->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('admin.user.index', compact('users', 'search'));
    }

    public function show($id)
    {
        $user = User::withCount(['rakBuku', 'riwayatBaca'])->findOrFail($id);
        $riwayat = \App\Models\RiwayatBaca::with('buku')
            ->where('user_id', $id)->orderByDesc('updated_at')->limit(10)->get();
        return view('admin.user.show', compact('user', 'riwayat'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
