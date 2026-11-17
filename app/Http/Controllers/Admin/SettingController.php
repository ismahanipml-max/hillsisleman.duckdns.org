<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::getAllAsMap();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'nullable|string',
            'link_maps' => 'nullable|string',
            'telepon' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:255',
            'hero_judul' => 'nullable|string|max:255',
            'hero_deskripsi' => 'nullable|string',
            'tahun_berdiri' => 'nullable|string|max:10',
        ]);

        foreach ($validated as $k => $v) {
            Setting::set($k, $v);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan website berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'password.required' => 'Password baru harus diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Password admin berhasil diubah!');
    }
}
