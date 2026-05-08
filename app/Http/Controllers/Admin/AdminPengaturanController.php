<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPengaturanController extends Controller
{
    public function index()
    {
        $admin = Admin::findOrFail(session('admin_id'));
        return view('admin.pengaturan.index', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $admin = Admin::findOrFail(session('admin_id'));

        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        $admin->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->route('admin.pengaturan.index')->with('success', 'Password berhasil diubah');
    }
}
