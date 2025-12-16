@extends ('layouts.app')

@section ('title', 'Organisasi Dimas Diajeng')
@section ('content')
<div class="container-fluid d-flex flex-column justify-content-center">
    <div class="container text-center my-5">
        <h1 class="fw-bold">Struktur Organisasi</h1>
    </div>
    <div class="container d-flex justify-content-center my-3">
        <img src="{{asset('image/organisasi/' . $organisasi->gambar_struktur_organisasi)}}" alt="struktur Organisasi" class="img-fluid mx-auto">
    </div>
    <div class="container mt-5 mb-3">
        {!! $organisasi->visi_misi !!}
    </div>
    <div class="container mb-5">
        <div class="row m-0 g-5">
            @foreach ($cards as $c)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="container">
                    <img src="{{asset('image/organisasi/' . $c->foto)}}" alt="{{'foto ' . $c->nama}}" class="img-fluid" style="height:341px; width:394px; object-fit:cover;">
                    <div class="text-center p-3 bg-blue-dark">
                        <p class="fw-bold text-white">{{ $c->nama }}</p>
                        <p class="text-warning">{{ $c->jabatan }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>



@endsection
