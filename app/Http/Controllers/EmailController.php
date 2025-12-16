<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendInformasi;
use App\Mail\informasiMail;

class EmailController extends Controller
{
    // Subscribe email dari footer
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:emails,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar'
        ]);

        email::create([
            'email' => $request->email,
            'subscribed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Terima kasih telah berlangganan!');
    }

    // Tampilkan daftar email berlangganan (Admin)
    public function showEmailBerlangganan()
    {
        $emails = email::orderBy('subscribed_at', 'desc')->get();
        return view('admin.email_berlangganan', compact('emails'));
    }

    // Hapus email berlangganan (Admin)
    public function deleteEmail($id)
    {
        $email = email::findOrFail($id);
        $email->delete();

        return redirect()->route('admin.email_berlangganan')->with('success', 'Email berhasil dihapus!');
    }

    // Tampilkan halaman kirim informasi (Admin)
    public function showKirimInformasi()
    {
        $history = DB::table('email_history')
                    ->orderBy('sent_at', 'desc')
                    ->get();

        return view('admin.kirim_informasi', compact('history'));
    }

    // Kirim email ke semua subscriber (Admin)
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $subscribers = email::all();

        if ($subscribers->count() == 0) {
            return redirect()->back()->with('error', 'Tidak ada email subscriber!');
        }

        try {
            Log::info('Mulai mengirim email ke ' . $subscribers->count() . ' subscriber');

            foreach ($subscribers as $subscriber) {
                try {
                    // Kirim langsung tanpa queue
                    Mail::to($subscriber->email)->send(new informasiMail($request->subject, $request->message));

                    Log::info('Email berhasil dikirim ke: ' . $subscriber->email);

                    // Simpan history
                    DB::table('email_history')->insert([
                        'email' => $subscriber->email,
                        'subject' => $request->subject,
                        'message' => $request->message,
                        'sent_at' => now()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim ke ' . $subscriber->email . ': ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Email berhasil dikirim ke ' . $subscribers->count() . ' subscriber!');
        } catch (\Exception $e) {
            Log::error('Error sendBroadcast: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
