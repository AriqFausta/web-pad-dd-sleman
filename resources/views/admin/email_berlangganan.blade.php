@extends('layouts.admin')

@section('title', 'Email Berlangganan')

@section('content')
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Header labels -->
    <div class="row px-2 mb-3">
        <div class="col-5"><span class="text-muted small" style="padding-left: 70px;">Email</span></div>
        <div class="col-4"><span class="text-muted small" style="padding-left: 120px;">Tanggal Berlangganan</span></div>
        <div class="col-3"><span class="text-muted small text-end">Aksi</span></div>
    </div>

    <div class="galeri-scroll-container" style="max-height: calc(100vh - 245px); overflow-y: auto; padding-right: 10px;">
        @forelse($emails as $email)
        <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; min-height:62px;">
            <div class="row align-items-center p-3">
                <div class="col-5 px-3">
                    <p class="mb-0" style="white-space: nowrap; font-size: 16px; padding-left: 20px;">{{ $email->email }}</p>
                </div>
                <div class="col-4 px-3">
                    <p class="mb-0 text-white small" style="padding-left: 120px; font-size: 16px; white-space:nowrap">
                        {{ $email->subscribed_at->format('l, d F Y') }}
                    </p>
                </div>
                <div class="col-3 text-end">
                    <form action="{{ route('admin.delete_email', $email->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus email ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger py-1 px-2">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center my-5">Belum ada email yang berlangganan.</p>
        @endforelse
    </div>
@endsection
