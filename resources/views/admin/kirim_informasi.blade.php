@extends('layouts.admin')

@section('title', 'Kirim Informasi')

@section('content')
 <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Montserrat', sans-serif;
      color: #1e2a38;
    }

    .card-custom {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px 30px;
      margin-bottom: 40px;
    }

    .card-header-custom {
      background-color: #233046;
      color: #fff;
      padding: 8px 12px;
      border-radius: 6px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .btn-send {
      background-color: #4ADE80;
      color: white;
      border: none;
      font-weight: 600;
      padding: 6px 20px;
      border-radius: 6px;
    }

    .btn-send:hover {
      background-color: #22c55e;
    }

    .card-dark {
      background-color: #233046;
      border-radius: 10px;
      padding: 12px 20px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .text-muted {
      color: #ffffff !important;
    }
  </style>

<div class="container mt-1">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- KIRIM EMAIL -->
    <div class="card-custom">
      <h5 class="fw-bold mb-3">Kirim Email</h5>
      <form action="{{ route('admin.send_broadcast') }}" method="POST">
        @csrf
        <div class="card-header-custom">Judul Email</div>
        <input type="text" name="subject" class="form-control mb-3" placeholder="Masukkan judul email..." required>

        <div class="card-header-custom">Isi Email</div>
        <textarea name="message" class="form-control mb-3" rows="6" placeholder="Tulis isi email di sini..." required></textarea>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn-send">Kirim</button>
        </div>
      </form>
    </div>

    <!-- HISTORY -->
    <h5 class="fw-bold mb-3">History</h5>

    <div class="row mb-2">
      <div class="col-6"><span class="small" style="color: #78797B;">Email</span></div>
      <div class="col-6 text-end"><span class="small" style="color: #78797B;">Tanggal Pengiriman</span></div>
    </div>

    @forelse($history as $item)
    <div class="card-dark">
      <span>{{ $item->email }}</span>
      <span>{{ \Carbon\Carbon::parse($item->sent_at)->format('l, d F Y') }}</span>
    </div>
    @empty
    <p class="text-center my-5">Belum ada history pengiriman email.</p>
    @endforelse
</div>
@endsection
