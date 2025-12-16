@extends('layouts.app')
@section('title', 'Detail Berita')
@section('content')
<div class="container-fluid align-content-center">
    <div class="container my-5 mx-auto" style="max-width: 1000px">
        <h1 class="fw-bold">{{ $berita->judul_berita }}</h1>
        <p class="text-muted">{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</p>
        <img src="{{ asset('image/berita/' . $berita->gambar_berita) }}" class="img-fluid mb-4" alt="" style="width : 1112px; height : 513px; object-fit: cover; object-position: center;">
        <p>
            {!! $berita->isi_berita !!}
        </p>
    </div>
</div>
@endsection
