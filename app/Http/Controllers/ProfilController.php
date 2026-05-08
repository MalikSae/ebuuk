<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalDibaca = \App\Models\RiwayatBaca::where('user_id', $user->id)->count();
        $totalRak = \App\Models\RakBuku::where('user_id', $user->id)->count();

        return Inertia::render('Profil', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'avatar' => $user->avatar,
                'avatar_url' => $user->avatar_url,
                'created_at' => $user->created_at->format('d F Y'),
            ],
            'stats' => [
                'totalDibaca' => $totalDibaca,
                'totalRak' => $totalRak,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'gender' => 'required|in:laki-laki,perempuan',
            'avatar' => 'required|string',
        ]);
        
        auth()->user()->update($request->only('name', 'email', 'gender', 'avatar'));
        
        return back()->with('success', 'Profil berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }
        
        auth()->user()->update(['password' => Hash::make($request->password_baru)]);
        
        return back()->with('success', 'Password berhasil diubah');
    }
}
