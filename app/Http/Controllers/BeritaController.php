<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\kategori;
use App\Models\Admin_Logs;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $beritas = Berita::with('kategori')->orderBy('created_at', 'desc')->get();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $beritas = $beritas->filter(function ($berita) use ($search) {
                return str_contains(strtolower($berita->judul_berita), $search);
            });
        }

        $PerPage = 9;
        $currentpage = request()->get('page', 1);
        $paged = $beritas->forPage($currentpage, $PerPage);
        $paginatedBeritas = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $beritas->count(),
            $PerPage,
            $currentpage,
            ['path' => url()->current()]
        );

        return view('Berita', ['beritas' => $paginatedBeritas]);
    }

    public function show($id){
        $beritas = Berita::with('kategori')->orderBy('created_at', 'desc')->get();
        $berita = $beritas->firstWhere('berita_id', (int) $id);

        if (!$berita) {
            abort(404);
        }

        return view('DetailBerita', compact('berita'));
    }

    public function showAdmin(Request $request)
    {
        $query = Berita::with('kategori');

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul_berita', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        // Urutkan: carousel aktif dulu (berdasarkan tanggal terbaru), lalu yang tidak aktif
        $beritas = $query->orderByDesc('carousel_active')
                        ->orderByDesc('created_at')
                        ->get();

        $kategoris = kategori::all();
        $pinnedCount = Berita::where('carousel_active', true)->count();

        return view('admin.kelola_berita', compact('beritas', 'kategoris', 'pinnedCount'));
    }

    public function createBerita(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'judul_berita' => 'required|string|max:255',
            'gambar_berita' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isi_berita' => 'required|string',
        ]);

        $gambarName = time() . '_' . $request->file('gambar_berita')->getClientOriginalName();
        $request->file('gambar_berita')->move(public_path('image/berita/'), $gambarName);

        Berita::create([
            'kategori_id' => $request->kategori_id,
            'judul_berita' => $request->judul_berita,
            'gambar_berita' => $gambarName,
            'isi_berita' => $request->isi_berita,
            'carousel_active' => false,
        ]);

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'create_berita'. $berita->berita_id . ' - ' . $berita->judul_berita,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_berita')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function updateBerita(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'judul_berita' => 'required|string|max:255',
            'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isi_berita' => 'required|string',
        ]);

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('gambar_berita')) {
            if (file_exists(public_path('image/berita/' . $berita->gambar_berita))) {
                unlink(public_path('image/berita/' . $berita->gambar_berita));
            }

            $gambarName = time() . '_' . $request->file('gambar_berita')->getClientOriginalName();
            $request->file('gambar_berita')->move(public_path('image/berita/'), $gambarName);
            $berita->gambar_berita = $gambarName;
        }

        $berita->kategori_id = $request->kategori_id;
        $berita->judul_berita = $request->judul_berita;
        $berita->isi_berita = $request->isi_berita;
        $berita->save();

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'update_berita'. $berita->berita_id . ' - ' . $berita->judul_berita,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_berita')->with('success', 'Berita berhasil diperbarui!');
    }

    public function deleteBerita($id)
    {
        $berita = Berita::findOrFail($id);

        if (file_exists(public_path('image/berita/' . $berita->gambar_berita))) {
            unlink(public_path('image/berita/' . $berita->gambar_berita));
        }

        $berita->delete();

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'delete_berita'. $berita->berita_id . ' - ' . $berita->judul_berita,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_berita')->with('success', 'Berita berhasil dihapus!');
    }

    public function togglePin($id)
    {
        $berita = Berita::findOrFail($id);
        $pinnedCount = Berita::where('carousel_active', true)->count();

        if (!$berita->carousel_active && $pinnedCount >= 5) {
            return redirect()->route('admin.kelola_berita')->with('error', 'Maksimal 5 berita dapat di-pin ke carousel!');
        }

        $berita->carousel_active = !$berita->carousel_active;
        $berita->save();

        $message = $berita->carousel_active ? 'Berita berhasil di-pin ke carousel!' : 'Berita berhasil di-unpin dari carousel!';
        return redirect()->route('admin.kelola_berita')->with('success', $message);
    }

    // Method untuk mendapatkan berita carousel (untuk homepage)
    public function getCarouselBerita()
    {
        return Berita::where('carousel_active', true)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();
    }
}
