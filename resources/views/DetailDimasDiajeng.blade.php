@extends('layouts.app')

@section('title', 'Detail ' . $galeri->nama)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-5 text-center mt-5 mb-5 mb-md-0">
            <img src="{{ asset('image/galeri/' . $galeri->foto) }}"
                alt="{{ $galeri->nama }}"
                class="img-fluid rounded img-cover">
        </div>

        <div class="col-md-7 mt-5">
            <h3 class="fw-bold mb-4">{{ $galeri->nama }}</h3>
            <h5 class="text-warning fw-bold mb-4">{{ $galeri->kategori }}</h5>

            <p class="text-secondary">
                {!! $galeri->deskripsi !!}
            </p>

            <div class="d-flex gap-2 mt-2">
                @if($galeri->instagram_dim)
                <a href="https://instagram.com/{{ $galeri->instagram_dim }}" target="_blank" class="btn btn-blue-dark rounded-2 px-2">
                    <i class="bi bi-instagram me-2"></i>
                    {{ $galeri->instagram_dim }}
                </a>
                @endif

                @if($galeri->instagram_dia)
                <a href="https://instagram.com/{{ $galeri->instagram_dia }}" target="_blank" class="btn btn-blue-dark rounded-2 px-2">
                    <i class="bi bi-instagram me-2"></i>
                    {{ $galeri->instagram_dia }}
                </a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

