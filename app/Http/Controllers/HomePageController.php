<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\konten;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $kontens = konten::all();

        $tahunTersedia = Galeri::whereNotNull('tahun')
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();


        $tahunAktif = $tahunTersedia[0] ?? date('Y');

        $galeriByYear = Galeri::whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->get()
            ->groupBy('tahun');

        $beritaCarousel = Berita::where('carousel_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $beritaCards = Berita::orderBy('created_at', 'desc')
            ->skip(3)
            ->take(3)
            ->get();


        return view('HomePage', compact(
            'kontens',
            'galeriByYear',
            'tahunTersedia',
            'tahunAktif',
            'beritaCarousel',
            'beritaCards'
        ));
    }
}
