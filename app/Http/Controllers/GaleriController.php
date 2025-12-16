<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Admin_Logs;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $galeris = Galeri::orderBy('tahun', 'desc')->get();

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $galeris = $galeris->filter(function ($galeri) use ($search) {
                return str_contains(strtolower($galeri->nama), $search);
            });
        }

        $PerPage = 9;
        $currentpage = request()->get('page', 1);
        $paged = $galeris->forPage($currentpage, $PerPage);
        $paginatedGaleris = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $galeris->count(),
            $PerPage,
            $currentpage,
            ['path' => url()->current()]
        );

        return view('Galeri', ['galeris' => $paginatedGaleris]);
    }

    public function show($id)
    {
        $galeris = Galeri::orderBy('tahun', 'desc')->get();
        $galeri = $galeris->firstWhere('galeri_id', (int) $id);

        if (!$galeri) {
            abort(404);
        }

        return view('DetailDimasDiajeng', compact('galeri'));
    }

    public function showAdmin(Request $request)
    {
        $query = Galeri::query();

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $galeris = $query->orderBy('tahun', 'desc')->get();

        // Dapatkan daftar tahun unik untuk filter dropdown
        $tahunList = Galeri::select('tahun')
                          ->distinct()
                          ->orderBy('tahun', 'desc')
                          ->pluck('tahun');

        return view('admin.kelola_galeri', compact('galeris', 'tahunList'));
    }

    public function createGaleri(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'kategori' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram_dim' => 'nullable|string|max:255',
            'instagram_dia' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $fotoName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->move(public_path('image/galeri/'), $fotoName);

        $linkInstagramDim = $request->instagram_dim
            ? 'https://instagram.com/' . ltrim($request->instagram_dim, '@')
            : '';

        $linkInstagramDia = $request->instagram_dia
            ? 'https://instagram.com/' . ltrim($request->instagram_dia, '@')
            : '';

        Galeri::create([
            'nama' => $request->nama,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'foto' => $fotoName,
            'instagram_dim' => $request->instagram_dim ?? null,
            'instagram_dia' => $request->instagram_dia ?? null,
            'link_instagram_dim' => $linkInstagramDim,
            'link_instagram_dia' => $linkInstagramDia,
            'deskripsi' => $request->deskripsi,
        ]);

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'create_galeri'. $galeri->galeri_id . ' - ' . $galeri->nama,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_galeri')->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function updateGaleri(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram_dim' => 'nullable|string|max:255',
            'instagram_dia' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $galeri = Galeri::findOrFail($id);

        if ($request->hasFile('foto')) {
            if (file_exists(public_path('image/galeri/' . $galeri->foto))) {
                unlink(public_path('image/galeri/' . $galeri->foto));
            }

            $fotoName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('image/galeri/'), $fotoName);
            $galeri->foto = $fotoName;
        }

        $linkInstagramDim = $request->instagram_dim
            ? 'https://instagram.com/' . ltrim($request->instagram_dim, '@')
            : '';

        $linkInstagramDia = $request->instagram_dia
            ? 'https://instagram.com/' . ltrim($request->instagram_dia, '@')
            : '';

        $galeri->nama = $request->nama;
        $galeri->tahun = $request->tahun;
        $galeri->kategori = $request->kategori;
        $galeri->instagram_dim = $request->instagram_dim ?? null;
        $galeri->instagram_dia = $request->instagram_dia ?? null;
        $galeri->link_instagram_dim = $linkInstagramDim;
        $galeri->link_instagram_dia = $linkInstagramDia;
        $galeri->deskripsi = $request->deskripsi;
        $galeri->save();

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'update_galeri'. $galeri->galeri_id . ' - ' . $galeri->nama,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_galeri')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function deleteGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (file_exists(public_path('image/galeri/' . $galeri->foto))) {
            unlink(public_path('image/galeri/' . $galeri->foto));
        }

        $galeri->delete();

        try {
            Admin_Logs::create([
                'admin_id' => Auth::id(),
                'action' => 'delete_galeri'. $galeri->galeri_id . ' - ' . $galeri->nama,
            ]);
        } catch (\Exception $e) {}

        return redirect()->route('admin.kelola_galeri')->with('success', 'Galeri berhasil dihapus!');
    }
}
