@extends('layouts.admin')

@section('title', 'Kelola Berita')

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
            <form action="{{ route('admin.kelola_berita') }}" method="GET" class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text border-2">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-2"
                               placeholder="Cari judul berita..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="kategori" class="form-select border-2">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->kategori_id }}"
                                {{ request('kategori') == $kategori->kategori_id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning me-2">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.kelola_berita') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Header (Fixed) -->
    <div class="row px-2 mb-3">
       <div class="col-2"><span class="text-muted small" style="padding-left: 30px;">Gambar</span></div>
       <div class="col-2"><span class="text-muted small">Judul Berita</span></div>
       <div class="col-2"><span class="text-muted small">Kategori</span></div>
       <div class="col-1"><span class="text-muted small">Tanggal</span></div>
       <div class="col-2"><span class="text-muted small">Status Carousel</span></div>
       <div class="col-3"><span class="text-muted small">Aksi</span></div>
    </div>

    <!-- Scrollable Container -->
    <div class="galeri-scroll-container" style="max-height: calc(100vh - 245px); overflow-y: auto; padding-right: 10px;">
        @forelse ($beritas as $berita)
        <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; height: 110px">
           <div class="row align-items-center p-2 h-100">
            <div class="col-2">
              <div class="d-flex align-items-center justify-content-center" style="padding-right: 50px;">
                <img src="{{ asset('image/berita/' . $berita->gambar_berita) }}" alt="Berita Image" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $berita->judul_berita }}</p>
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                <span class="badge bg-warning text-dark">{{ $berita->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
              </div>
            </div>
            <div class="col-1">
              <div class="d-flex align-items-center">
                <p class="mb-0 text-white small text-truncate">{{ $berita->created_at->format('d M Y') }}</p>
              </div>
            </div>
            <div class="col-2">
              <div class="d-flex align-items-center">
                @if($berita->carousel_active)
                    <span class="badge bg-success">Aktif di Carousel</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
              </div>
            </div>
            <div class="col-3">
              <div class="d-flex justify-content-end me-3 gap-2">
                <form action="{{ route('admin.toggle_pin_berita', $berita->berita_id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn py-1 px-2 {{ $berita->carousel_active ? 'btn-secondary' : 'btn-info' }}"
                            title="{{ $berita->carousel_active ? 'Unpin dari Carousel' : 'Pin ke Carousel' }}"
                            {{ !$berita->carousel_active && $pinnedCount >= 5 ? 'disabled' : '' }}>
                        <i class="fa-solid fa-thumbtack"></i>
                    </button>
                </form>
                <button class="btn btn-warning py-1 px-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $berita->berita_id }}">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form action="{{ route('admin.delete_berita', $berita->berita_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
        <div class="modal fade" id="editModal{{ $berita->berita_id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $berita->berita_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $berita->berita_id }}">Edit Berita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.update_berita', $berita->berita_id) }}" method="POST" enctype="multipart/form-data" class="isi-konten-form" id="editBeritaForm{{ $berita->berita_id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row gy-0 gx-0 px-4">
                                <div class="col-auto me-5">
                                    <label class="form-label">Gambar Berita</label>
                                    <div class="bg-blue-dark rounded-3 text-center overflow-hidden" style="width:213px; height:213px;">
                                        <img src="{{ asset('image/berita/' . $berita->gambar_berita) }}" id="previewImg{{ $berita->berita_id }}" alt="" style="object-fit: cover; width:100%; height:100%;">
                                    </div>
                                    <label for="gambarInput{{ $berita->berita_id }}" class="btn btn-blue-dark tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                        <i class="fa-solid fa-upload me-2"></i>Upload Gambar
                                    </label>
                                    <input type="file" name="gambar_berita" class="d-none" id="gambarInput{{ $berita->berita_id }}" accept="image/*">
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori_id" class="form-select bg-blue-dark text-white" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->kategori_id }}"
                                                    {{ $berita->kategori_id == $kategori->kategori_id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Judul Berita</label>
                                        <input type="text" name="judul_berita" class="form-control bg-blue-dark text-white" value="{{ $berita->judul_berita }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Isi Berita</label>
                                        <div id="editorEdit{{ $berita->berita_id }}" style="height: 300px;">{!! $berita->isi_berita !!}</div>
                                        <input type="hidden" name="isi_berita" id="isiBeritaEdit{{ $berita->berita_id }}">
                                    </div>
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
        <p class="text-center my-5">Tidak ada data berita tersedia.</p>
        @endforelse
    </div>

    <!-- Button Add (Fixed) -->
    <div class="card mb-3 p-2 position-fixed bottom-0 me-5" style="border-radius:12px; background-color:#ffc107; width: 1183px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addModal">
        <button class="btn" style="color: white">
            <i class="fa-solid fa-plus me-2"></i>Tambah Berita
        </button>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.create_berita') }}" method="POST" enctype="multipart/form-data" class="isi-konten-form" id="addBeritaForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row gy-0 gx-0 px-4">
                            <div class="col-auto me-5">
                                <label class="form-label">Gambar Berita</label>
                                <div class="bg-blue-dark rounded-3 text-center d-flex align-items-center justify-content-center" style="width:213px; height:213px;">
                                    <img src="" id="previewImgAdd" alt="" class="d-none" style="object-fit: cover; width:100%; height:100%; border-radius: 10px;">
                                    <i class="fa-solid fa-image fa-3x text-muted" id="placeholderIcon"></i>
                                </div>
                                <label for="gambarInputAdd" class="btn btn-blue-dark tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                    <i class="fa-solid fa-upload me-2"></i>Upload Gambar
                                </label>
                                <input type="file" name="gambar_berita" class="d-none" id="gambarInputAdd" accept="image/*" required>
                            </div>
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori_id" class="form-select bg-blue-dark text-white" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->kategori_id }}">
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Judul Berita</label>
                                    <input type="text" name="judul_berita" class="form-control bg-blue-dark text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Isi Berita</label>
                                    <div id="editorAdd" style="height: 300px;"></div>
                                    <input type="hidden" name="isi_berita" id="isiBeritaAdd">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Tambah Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview gambar untuk Add Modal
        const gambarInputAdd = document.getElementById('gambarInputAdd');
        const previewImgAdd = document.getElementById('previewImgAdd');
        const placeholderIcon = document.getElementById('placeholderIcon');

        if (gambarInputAdd) {
            gambarInputAdd.addEventListener('change', function(e) {
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

        // Submit form Add
        const addForm = document.getElementById('addBeritaForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                document.getElementById('isiBeritaAdd').value = quillAdd.root.innerHTML;
            });
        }

        // Preview dan Quill untuk setiap Edit Modal
        @foreach($beritas as $berita)
        const gambarInput{{ $berita->berita_id }} = document.getElementById('gambarInput{{ $berita->berita_id }}');
        const previewImg{{ $berita->berita_id }} = document.getElementById('previewImg{{ $berita->berita_id }}');

        if (gambarInput{{ $berita->berita_id }}) {
            gambarInput{{ $berita->berita_id }}.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg{{ $berita->berita_id }}.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Initialize Quill untuk Edit Modal
        var quillEdit{{ $berita->berita_id }} = new Quill('#editorEdit{{ $berita->berita_id }}', {
            theme: 'snow'
        });

        // Submit form Edit
        const editForm{{ $berita->berita_id }} = document.getElementById('editBeritaForm{{ $berita->berita_id }}');
        if (editForm{{ $berita->berita_id }}) {
            editForm{{ $berita->berita_id }}.addEventListener('submit', function(e) {
                document.getElementById('isiBeritaEdit{{ $berita->berita_id }}').value = quillEdit{{ $berita->berita_id }}.root.innerHTML;
            });
        }
        @endforeach
    });
    </script>
@endsection
