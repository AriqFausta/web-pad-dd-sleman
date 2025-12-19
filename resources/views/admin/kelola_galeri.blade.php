@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search & Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <form action="{{ route('admin.kelola_galeri') }}" method="GET" class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text border-2">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-2"
                               placeholder="Cari nama Dimas Diajeng atau kategori..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="tahun" class="form-select border-2">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}"
                                {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning me-2">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.kelola_galeri') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Header (Fixed) -->
    <div class="row px-2 mb-3">
       <div class="col-2"><span class="text-muted small" style="padding-left: 30px;">Foto</span></div>
       <div class="col-2"><span class="text-muted small">Nama Dimas Diajeng</span></div>
       <div class="col-1"><span class="text-muted small">Tahun</span></div>
       <div class="col-2"><span class="text-muted small">Kategori Juara</span></div>
       <div class="col-2"><span class="text-muted small">Instagram Dimas</span></div>
       <div class="col-2"><span class="text-muted small">Instagram Diajeng</span></div>
       <div class="col-1"><span class="text-muted small">Edit</span></div>
    </div>

    <!-- Scrollable Container -->
    <div class="galeri-scroll-container" style="max-height: calc(100vh - 245px); overflow-y: auto; padding-right: 10px;">
        @forelse ($galeris as $galeri)
        <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; height: 110px">
           <div class="row align-items-center p-2 h-100">
            <div class="col-2">
              <div class="d-flex align-items-center justify-content-center" style="padding-right: 50px;">
                <img src="{{ asset('image/galeri/' . $galeri->foto) }}" alt="Profile Image" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $galeri->nama }}</p>
              </div>
            </div>
            <div class="col-1">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $galeri->tahun }}</p>
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $galeri->kategori }}</p>
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $galeri->instagram_dim }}</p>
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $galeri->instagram_dia }}</p>
              </div>
            </div>
            <div class="col-1">
              <div class="d-flex justify-content-end me-3">
                <button class="btn btn-warning me-3 py-1 px-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $galeri->galeri_id }}"><i class="fa-solid fa-pen"></i></button>
                <form action="{{ route('admin.delete_galeri', $galeri->galeri_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus galeri ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger py-1 px-2">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
              </div>
            </div>
           </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $galeri->galeri_id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $galeri->galeri_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $galeri->galeri_id }}">Edit Galeri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.update_galeri', $galeri->galeri_id) }}" method="POST" enctype="multipart/form-data" class="isi-konten-form" id="editGaleriForm{{ $galeri->galeri_id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row gy-0 gx-0 px-4">
                                <div class="col-auto me-5">
                                    <label class="form-label">Foto</label>
                                    <div class="bg-blue-dark rounded-3 text-center overflow-hidden" style="width:213px; height:213px;">
                                        <img src="{{ asset('image/galeri/' . $galeri->foto) }}" id="previewImg{{ $galeri->galeri_id }}" alt="" style="object-fit: cover; width:100%; height:100%;">
                                    </div>
                                    <label for="fotoInput{{ $galeri->galeri_id }}" class="btn btn-blue-dark tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                        <i class="fa-solid fa-upload me-2"></i>Upload Foto
                                    </label>
                                    <input type="file" name="foto" class="d-none" id="fotoInput{{ $galeri->galeri_id }}" accept="image/*">
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-1">
                                        <label class="form-label">Nama Dimas Diajeng</label>
                                        <input type="text" name="nama" class="form-control bg-blue-dark" value="{{ $galeri->nama }}" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" name="tahun" class="form-control bg-blue-dark" value="{{ $galeri->tahun }}" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Kategori Juara</label>
                                        <input type="text" name="kategori" class="form-control bg-blue-dark" value="{{ $galeri->kategori }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Instagram Dimas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-blue-dark text-white border-0">@</span>
                                                    <input type="text" name="instagram_dim" class="form-control bg-blue-dark" value="{{ $galeri->instagram_dim }}" placeholder="username">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Instagram Diajeng</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-blue-dark text-white border-0">@</span>
                                                    <input type="text" name="instagram_dia" class="form-control bg-blue-dark" value="{{ $galeri->instagram_dia }}" placeholder="username">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <div id="editor{{ $galeri->galeri_id }}" style="height: 200px;">{!! $galeri->deskripsi !!}</div>
                                    <input type="hidden" name="deskripsi" class="text-white" id="deskripsi{{ $galeri->galeri_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center my-5">Tidak ada data galeri tersedia.</p>
        @endforelse
    </div>

    <!-- Button Add (Fixed) -->
    <div class="card mb-3 p-2 position-fixed bottom-0 me-5 btn-tambah" data-bs-toggle="modal" data-bs-target="#addModal">
        <button class="btn" style="color: white">
            <i class="fa-solid fa-plus me-2"></i>Tambah Galeri
        </button>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.create_galeri') }}" method="POST" enctype="multipart/form-data" class="isi-konten-form" id="addGaleriForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row gy-0 gx-0 px-4">
                            <div class="col-auto me-5">
                                <label class="form-label">Foto</label>
                                <div class="bg-blue-dark rounded-3 text-center d-flex align-items-center justify-content-center" style="width:213px; height:213px;">
                                    <img src="" id="previewImgAdd" alt="" class="d-none" style="object-fit: cover; width:100%; height:100%; border-radius: 10px;">
                                    <i class="fa-solid fa-image fa-3x text-muted" id="placeholderIcon"></i>
                                </div>
                                <label for="fotoInputAdd" class="btn btn-blue-dark tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                    <i class="fa-solid fa-upload me-2"></i>Upload Foto
                                </label>
                                <input type="file" name="foto" class="d-none" id="fotoInputAdd" accept="image/galeri/*" required>
                            </div>
                            <div class="col-md-9">
                                <div class="mb-1">
                                    <label class="form-label">Nama Dimas Diajeng</label>
                                    <input type="text" name="nama" class="form-control bg-blue-dark" required>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" name="tahun" class="form-control bg-blue-dark" required>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Kategori Juara</label>
                                    <input type="text" name="kategori" class="form-control bg-blue-dark" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Instagram Dimas</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-blue-dark text-white border-0">@</span>
                                                <input type="text" name="instagram_dim" class="form-control bg-blue-dark" value="" placeholder="username" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Instagram Diajeng</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-blue-dark text-white border-0">@</span>
                                                <input type="text" name="instagram_dia" class="form-control bg-blue-dark" placeholder="username" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <div id="editorAdd" style="height: 200px;"></div>
                                <input type="hidden" name="deskripsi" id="deskripsiAdd">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Tambah Galeri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview foto untuk Add Modal
        const fotoInputAdd = document.getElementById('fotoInputAdd');
        const previewImgAdd = document.getElementById('previewImgAdd');
        const placeholderIcon = document.getElementById('placeholderIcon');

        if (fotoInputAdd) {
            fotoInputAdd.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImgAdd.src = e.target.result;
                        previewImgAdd.classList.remove('d-none');
                        if (placeholderIcon) {
                            placeholderIcon.classList.add('d-none');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Initialize Quill untuk Add Modal
        var quillAdd = new Quill('#editorAdd', {
            theme: 'snow'
        });

        // Submit form Add - transfer Quill content ke hidden input
        const addForm = document.getElementById('addGaleriForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                document.getElementById('deskripsiAdd').value = quillAdd.root.innerHTML;
            });
        }

        // Preview dan Quill untuk setiap Edit Modal
        @foreach($galeris as $galeri)
        const fotoInput{{ $galeri->galeri_id }} = document.getElementById('fotoInput{{ $galeri->galeri_id }}');
        const previewImg{{ $galeri->galeri_id }} = document.getElementById('previewImg{{ $galeri->galeri_id }}');

        if (fotoInput{{ $galeri->galeri_id }}) {
            fotoInput{{ $galeri->galeri_id }}.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg{{ $galeri->galeri_id }}.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Initialize Quill untuk Edit Modal
        var quillEdit{{ $galeri->galeri_id }} = new Quill('#editor{{ $galeri->galeri_id }}', {
            theme: 'snow'
        });

        // Submit form Edit - transfer Quill content ke hidden input
        const editForm{{ $galeri->galeri_id }} = document.getElementById('editGaleriForm{{ $galeri->galeri_id }}');
        if (editForm{{ $galeri->galeri_id }}) {
            editForm{{ $galeri->galeri_id }}.addEventListener('submit', function(e) {
                document.getElementById('deskripsi{{ $galeri->galeri_id }}').value = quillEdit{{ $galeri->galeri_id }}.root.innerHTML;
            });
        }
        @endforeach
    });
    </script>
@endsection
