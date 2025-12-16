<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konten;
use App\Models\Admin_Logs;
use Illuminate\Support\Facades\Auth;

class KontenController extends Controller
{
    public function showKonten() {
        $kontens = konten::all();
        $konten = konten::first();
        return view ('admin.kelola_konten', compact('kontens', 'konten'));
    }

    public function updateKonten(Request $request, $id) {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // 2MB max
        ]);

        $konten = konten::findOrFail($id);
        $konten->judul = $request->input('judul');
        $konten->deskripsi = $request->input('deskripsi');

        // Handle file upload
        if ($request->hasFile('icon')) {
            // Hapus file lama jika ada
            if ($konten->icon && file_exists(public_path('image/icon/' . $konten->icon))) {
                unlink(public_path('image/icon/' . $konten->icon));
            }

            // Upload file baru
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image/icon/'), $filename);
            $konten->icon = $filename;
        }

        $konten->save();

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'update_konten'. $konten->id . ' - ' . $konten->judul,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_konten')->with('success', 'Konten berhasil diperbarui.');
    }
}
