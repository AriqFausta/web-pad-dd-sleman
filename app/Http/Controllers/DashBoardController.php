<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Email;
use App\Models\Admin_Logs;

class DashBoardController extends Controller
{
    public function index(Request $request)
    {
        $totalGaleri = Galeri::count();
        $totalBerita = Berita::count();
        $totalEmail = Email::count();
        $logs = Admin_Logs::latest()->take(10)->get();
        return view('admin.dashboard', compact(
            'totalGaleri',
            'totalEmail',
            'totalBerita',
            'logs'
        ));
    }
}
