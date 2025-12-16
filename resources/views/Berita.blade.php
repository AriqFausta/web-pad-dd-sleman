@extends('layouts.app')
@section('title', 'Halaman Berita')
@section('content')
<div class="container-fluid">
    <div class="container my-5">
        <div class="mx-auto text-center berita-container">
            <h1 class="fw-bold">Berita</h1>
            <p>mengenal lebih dekat peran, fungsi, serta tujuan Dimas Diajeng Sleman dalam
                mengangkat potensi daerah, mempromosikan pariwisata, dan menjadi
                teladan generasi muda di masyarakat.
            </p>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center my-5">
        <form action="{{ route('Berita.search')}}" method="GET" class="w-100">
            <div class="input-group search-bar mx-auto">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Cari tahu tentang Dimas Diajeng Sleman" value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="container my-5">
        <div class="row m-0 g-5 mt-4">
            @forelse ($beritas as $b)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="container">
                    <img src="{{asset('image/berita/' . $b->gambar_berita)}}" alt="{{ $b->judul }}" class="img-fluid berita-card-image">
                    <P class="my-2">{{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d F Y') }}</P>
                    <h3 class="fw-bold berita-card-judul">{{ $b->judul_berita }}</h3>
                    <P class="berita-card-isi">
                        {{ Str::limit(strip_tags($b->isi_berita), 100) }}
                    </P>
                    <a href="{{ route('Berita.show', $b->berita_id)}}" class="btn btn-blue-dark rounded px-2 py-1">Selengkapnya</a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h5 class="mb-3">Belum ada berita.</h5>
                    @if(request('search'))
                        <p>Pencarian "<strong>{{ request('search') }}</strong>" tidak ditemukan.</p>
                        <a href="{{ route('Berita.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>

    @if ($beritas->hasPages())
    <div class="d-flex justify-content-center align-items-center gap-2 my-5 d-none d-lg-flex">
        {{-- Tombol Prev --}}
        @if ($beritas->onFirstPage())
            <button class="carousel-control-prev static-control mx-1 disabled" type="button" style="position:static;transform:none;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
        @else
            <a href="{{ $beritas->previousPageUrl() }}" class="carousel-control-prev static-control mx-1" style="position:static;transform:none;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
        @endif

        {{-- Indikator halaman --}}
        <div class="carousel-indicators position-static m-0">
            @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                <a
                    href="{{ $url }}"
                    class="pagination-btn mx-1 {{ $page == $beritas->currentPage() ? 'active' : '' }}"
                    aria-current="{{ $page == $beritas->currentPage() ? 'true' : 'false'}}">
                    {{ $page }}
                </a>
            @endforeach
        </div>

        {{-- Tombol Next --}}
        @if ($beritas->hasMorePages())
            <a href="{{ $beritas->nextPageUrl() }}" class="carousel-control-next static-control mx-1" style="position:static;transform:none;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        @else
            <button class="carousel-control-next static-control mx-1 disabled" type="button" style="position:static;transform:none;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        @endif
    </div>
    @endif
</div>
@endsection
