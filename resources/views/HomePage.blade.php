@extends('layouts.app')

@section('title', 'Halaman Home')

@section('content')


<div class="container-fluid px-0">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($beritaCarousel as $bc)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('image/berita/' . $bc->gambar_berita) }}" class="d-block w-100 carousel-img img-fluid" alt="{{ $bc->judul_berita }}">
                    <div class="carousel-caption">
                        <h1>{{ $bc->judul_berita }}</h1>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev d-lg-none" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-lg-none" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <div class="d-flex justify-content-center align-items-center gap-2 mt-3 d-none d-lg-flex">
            <button class="carousel-control-prev static-control mx-1" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev" style="position:static;transform:none;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Prev</span>
            </button>

            <div class="carousel-indicators position-static m-0">
                @foreach ($beritaCarousel as $bc)
                    <button
                        type="button"
                        data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}"
                        aria-current="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="Slide {{ $loop->iteration }}"
                    ></button>
                @endforeach
            </div>

            <button class="carousel-control-next static-control" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next" style="position:static;transform:none;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<div class="container my-5">
  <div class="mx-auto text-center" style="max-width: 600px;">
    <h1 class="mb-5 fw-bold">{{ $kontens[0]->judul }}</h1>
    <p class="mt-5">
      {{ $kontens[0]->deskripsi }}
    </p>
  </div>
</div>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3 text-center mb-4">
            <img src="{{asset('image/icon/' . $kontens[1]->icon )}}" class="img-fluid mb-3" alt="{{ 'icon' . $kontens[1]->judul }}" style="height: 120px; width:120px;">
            <h2 class="my-4 card-header-2">{{ $kontens[1]->judul }}</h2>
            <p class="card-text">{{ $kontens[1]->deskripsi }}</p>
        </div>
        <div class="col-12 col-md-3 text-center mb-4">
            <img src="{{asset('image/icon/' . $kontens[2]->icon )}}" class="img-fluid mb-3" alt="{{ 'icon' . $kontens[2]->judul }}" style="height: 120px; width:120px;">
            <h2 class="my-4 px-5">{{ $kontens[2]->judul }}</h2>
            <p class="card-text">{{ $kontens[2]->deskripsi }}</p>
        </div>
        <div class="col-12 col-md-3 text-center mb-4">
            <img src="{{asset('image/icon/' . $kontens[3]->icon )}}" class="img-fluid mb-3" alt="{{ 'icon' . $kontens[3]->judul }}" style="height: 120px; width:120px;">
            <h2 class="my-4 card-header-2">{{ $kontens[3]->judul }}</h2>
            <p class="card-text">{{ $kontens[3]->deskripsi }}</p>
        </div>
    </div>
</div>


<div class="container my-5">
    <div class="d-flex justify-content-center align-items-center gap-3 m-4">
        <button id="prev-year" class="btn p-0 border-0 bg-transparent">
            <i class="bi bi-chevron-left fs-4"></i>
        </button>
        <h1 class="m-0 fw-bold text-center" id="year-title">
            Galeri Dimas Diajeng {{ $tahunAktif }}
        </h1>
        <button id="next-year" class="btn p-0 border-0 bg-transparent">
            <i class="bi bi-chevron-right fs-4"></i>
        </button>
    </div>
    <div id="section-content">
        @forelse($galeriByYear as $thn => $items)
            <div class="page {{ $thn == $tahunAktif ? '' : 'd-none' }}" id="page-{{ $thn }}">
                <div class="container-fluid">
                    <div class="row m-0 g-5">
                        @foreach($items as $g)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-custom-1">
                                <img src="{{ asset('image/galeri/' . $g->foto) }}" class="card-img-top img-fluid" alt="{{ $g->nama }}">
                                <div class="card-body">
                                    <h3 class="card-title ms-2">{{ $g->nama }}</h3>
                                    <h4 class="card-sub-title ms-2 text-warning">{{ $g->kategori }}</h4>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <p class="mb-1 ms-2">
                                                <i class="bi bi-instagram me-1"></i>{{ $g->instagram_dim }}
                                            </p>
                                            <p class="mb-1 ms-2">
                                                <i class="bi bi-instagram me-1"></i>{{ $g->instagram_dia }}
                                            </p>
                                        </div>
                                        <div class="col-md-5 d-flex align-items-center">
                                            <a href="{{ route('galeri.show', $g->galeri_id) }}" class="btn btn-blue-dark rounded px-2 py-1">
                                                Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <h5 class="mb-3">Belum ada galeri</h5>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<div class="container my-5">
    <h1 class="text-center fw-bold">Berita</h1>
    <div class="row m-0 g-5 mt-4">
        @forelse ($beritaCards as $b)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="container">
                <img src="{{asset('image/berita/' . $b->gambar_berita)}}" alt="{{ $b->judul }}" class="img-fluid berita-card-image">
                <P class="my-2">{{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d F Y') }}</P>
                <h3 class="fw-bold berita-card-judul">{{ $b->judul_berita }}</h3>
                <P class="berita-card-isi">
                    {{ Str::limit(strip_tags($b->isi_berita), 100) }}
                </P>
                <a href="{{ route('Berita.show', $b->berita_id) }}" class="btn btn-blue-dark rounded px-2 py-1">Selengkapnya</a>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h5 class="mb-3">Belum ada berita.</h5>
        </div>
        @endforelse
    </div>
</div>


@endsection

@push('scripts')
<script>
    let currentYear = {{ $tahunAktif }};
    const tahunTersedia = @json($tahunTersedia);

    const title = document.getElementById('year-title');
    const prevBtn = document.getElementById('prev-year');
    const nextBtn = document.getElementById('next-year');

    function updateYear() {
        title.textContent = `Galeri Dimas Diajeng ${currentYear}`;

        // Hide semua
        document.querySelectorAll('.page').forEach(p => p.classList.add('d-none'));

        // Show yang sesuai currentYear
        const target = document.getElementById('page-' + currentYear);
        if (target) target.classList.remove('d-none');
    }

    if (tahunTersedia.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }

    prevBtn.addEventListener('click', () => {
        const index = tahunTersedia.indexOf(currentYear);
        if (index < tahunTersedia.length - 1) {
            currentYear = tahunTersedia[index + 1];
            updateYear();
        }
    });

    nextBtn.addEventListener('click', () => {
        const index = tahunTersedia.indexOf(currentYear);
        if (index > 0) {
            currentYear = tahunTersedia[index - 1];
            updateYear();
        }
    });
</script>
@endpush

