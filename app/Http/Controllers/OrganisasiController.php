<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\Organisasi_Card;
use App\Models\Admin_Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
        public function index() {
        $organisasi = Organisasi::findOrFail(1);
        $cards = $organisasi->cards;
        return view ('OrganisasiDimasDiajeng', compact(
            'organisasi',
            'cards'
        ));
        }

        public function showadmmin() {
            $organisasis = Organisasi::all();
            return view('admin.kelola_organisasi', compact('organisasis'));
        }

        public function updateOrganisasi(Request $request, $id) {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            $organisasi = Organisasi::findOrFail($id);
            $organisasi->judul = $request->input('judul');
            $organisasi->deskripsi = $request->input('deskripsi');

            $organisasi->save();

            try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'update_organisasi'. $organisasi->organisasi_id . ' - ' . $organisasi->judul,
            ]);
        } catch (\Exception $e) {}

            return redirect()->route('admin.kelola_organisasi')->with('success', 'Organisasi berhasil diperbarui.');
        }

        public function updateMindMap(Request $request, $id) {
            $request->validate([
                'gambar_struktur_organisasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            try {
                $organisasi = Organisasi::findOrFail($id);

                if ($request->hasFile('gambar_struktur_organisasi')) {
                    // Delete old image
                    if ($organisasi->gambar_struktur_organisasi && file_exists(public_path('image/organisasi/' . $organisasi->gambar_struktur_organisasi))) {
                        unlink(public_path('image/organisasi/' . $organisasi->gambar_struktur_organisasi));
                    }

                    // Upload new image
                    $file = $request->file('gambar_struktur_organisasi');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('image/organisasi/'), $filename);
                    $organisasi->gambar_struktur_organisasi = $filename;
                }

                $organisasi->save();

                try {
                    Admin_Logs::create([
                        'admin_id' => Auth::id(),
                        'action' => 'update_organisasi'. $organisasi->organisasi_id . ' - ' . $organisasi->judul,
                    ]);
                } catch (\Exception $e) {}

                return redirect()->route('admin.kelola_organisasi')->with('success', 'Mind Map berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->route('admin.kelola_organisasi')->with('error', 'Gagal memperbarui Mind Map: ' . $e->getMessage());
            }
        }

        public function updateDeskripsi(Request $request, $id) {
            $request->validate([
                'visi_misi' => 'required|string',
            ]);

            try {
                $organisasi = Organisasi::findOrFail($id);
                $organisasi->visi_misi = $request->input('visi_misi');
                $organisasi->save();

                try {
                    Admin_Logs::create([
                        'admin_id' => Auth::id(),
                        'action' => 'update_organisasi'. $organisasi->organisasi_id . ' - ' . $organisasi->judul,
                    ]);
                } catch (\Exception $e) {}

                return redirect()->route('admin.kelola_organisasi')->with('success', 'Deskripsi berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->route('admin.kelola_organisasi')->with('error', 'Gagal memperbarui deskripsi: ' . $e->getMessage());
            }
        }

        public function createAnggota(Request $request) {
            $request->validate([
                'organisasi_id' => 'required|exists:organisasis,organisasi_id',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
            ]);

            try {
                $anggota = new Organisasi_Card();
                $anggota->organisasi_id = $request->input('organisasi_id');
                $anggota->nama = $request->input('nama');
                $anggota->jabatan = $request->input('jabatan');

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('image/organisasi/'), $filename);
                    $anggota->foto = $filename;
                }

                $anggota->save();

                try {
                Admin_Logs::create([
                    'admin_id' => Auth::id(),
                    'action' => 'create_organisasi_card'. $anggota->id . ' - ' . $anggota->nama,
                ]);
                } catch (\Exception $e) {}

                return redirect()->route('admin.kelola_organisasi')->with('success', 'Pengurus berhasil ditambahkan.');
            } catch (\Exception $e) {
                return redirect()->route('admin.kelola_organisasi')->with('error', 'Gagal menambahkan pengurus: ' . $e->getMessage());
            }
        }

        public function updateAnggota(Request $request, $id) {
            $request->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
            ]);

            try {
                $anggota = Organisasi_Card::findOrFail($id);
                $anggota->nama = $request->input('nama');
                $anggota->jabatan = $request->input('jabatan');

                if ($request->hasFile('foto')) {
                    // Delete old image
                    if ($anggota->foto && file_exists(public_path('image/' . $anggota->foto))) {
                        unlink(public_path('image/organisasi/' . $anggota->foto));
                    }

                    // Upload new image
                    $file = $request->file('foto');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('image/organisasi/'), $filename);
                    $anggota->foto = $filename;
                }

                $anggota->save();

                try {
                Admin_Logs::create([
                    'admin_id' => Auth::id(),
                    'action' => 'update_organisasi_card'. $anggota->id . ' - ' . $anggota->nama,
                ]);
                } catch (\Exception $e) {}

                return redirect()->route('admin.kelola_organisasi')->with('success', 'Pengurus berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->route('admin.kelola_organisasi')->with('error', 'Gagal memperbarui pengurus: ' . $e->getMessage());
            }
        }

        public function deleteAnggota($id) {
            try {
                $anggota = Organisasi_Card::findOrFail($id);

                // Delete image
                if ($anggota->foto && file_exists(public_path('image/organisasi/' . $anggota->foto))) {
                    unlink(public_path('image/organisasi/' . $anggota->foto));
                }

                $anggota->delete();

                try {
                Admin_Logs::create([
                    'admin_id' => Auth::id(),
                    'action' => 'delete_organisasi_card'. $anggota->id . ' - ' . $anggota->nama,
                ]);
                } catch (\Exception $e) {}

                return redirect()->route('admin.kelola_organisasi')->with('success', 'Pengurus berhasil dihapus.');
            } catch (\Exception $e) {
                return redirect()->route('admin.kelola_organisasi')->with('error', 'Gagal menghapus pengurus: ' . $e->getMessage());
            }
        }
}
