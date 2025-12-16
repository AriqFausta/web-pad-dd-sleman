<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\informasiMail;

class SendInformasi implements ShouldQueue
{
    use Queueable;

    public $email;
    public $subject;
    public $content;

    // Maksimal retry jika gagal
    public $tries = 3;

    // Timeout
    public $timeout = 120;

    public function __construct($email, $subject, $content)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function handle()
    {
        try {
            Log::info('Mulai mengirim email ke: ' . $this->email);

            Mail::to($this->email)->send(new informasiMail($this->subject, $this->content));

            Log::info('Email berhasil dikirim ke: ' . $this->email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email ke ' . $this->email . ': ' . $e->getMessage());
            throw $e; // Re-throw untuk retry
        }
    }

    // Method dipanggil ketika job gagal
    public function failed(\Throwable $exception)
    {
        Log::error('Job gagal untuk email ' . $this->email . ': ' . $exception->getMessage());
    }
}
