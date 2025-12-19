@extends('layouts.admin')

@section('title', 'Kelola Organisasi')

@section('content')
<div class="container mt-2">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert>
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

    <h2 class="fw-bold mb-3" style="color: #233046;">Mind Map Struktur Organisasi</h2>

    <div class="row px-2 mb-3">
       <div class="col-2"><span class="text-muted small" style="padding-left: 30px;">Foto</span></div>
       <div class="col-9"><span class="text-muted small">Deskripsi</span></div>
       <div class="col-1"><span class="text-muted small">Edit</span></div>
    </div>

    <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046;">
        <div class="row align-items-center p-2">
            <div class="col-2">
            <div class="d-flex align-items-center justify-content-center" style="padding-right: 50px;">
                <img src="{{ asset('image/organisasi/' . $organisasis[0]->gambar_struktur_organisasi) }}" class="rounded" alt="Mind Map Image" style="width: 45px; height: 45px; object-fit: cover;">
            </div>
            </div>
            <div class="col-9">
            <div class="d-flex align-items-center">
                <p class="mb-0 text-white small">Struktur Organisasi Pemuda</p>
            </div>
            </div>
            <div class="col-1">
            <div class="d-flex justify-content-end me-2">

                <button class="btn btn-warning me-2 py-1 px-2" data-bs-toggle="modal" data-bs-target="#editMindMapModal"><i class="fa-solid fa-pen"></i></button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Mind Map -->
    <div class="modal fade" id="editMindMapModal" tabindex="-1" aria-labelledby="editMindMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMindMapModalLabel">Edit Mind Map Struktur Organisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.update_mindmap', $organisasis[0]->organisasi_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <img src="{{ asset('image/organisasi/' . $organisasis[0]->gambar_struktur_organisasi) }}" id="previewMindMap" class="rounded" alt="Mind Map Image" style="max-width: 100%; height: auto; max-height: 500px; object-fit: contain;">
                        </div>
                        <div class="mb-3">
                            <label for="fotoMindMap" class="btn tombol-upload" style="cursor: pointer; width: 100%;">
                                <i class="fa-solid fa-upload me-2"></i>Upload Foto Mind Map
                            </label>
                            <input type="file" name="gambar_struktur_organisasi" class="d-none" id="fotoMindMap" accept="image/*">
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

    <h2 class="fw-bold mb-3" style="color: #233046;">Deskripsi</h2>
    <div class="row px-2 mb-3">
        <div class="col-11"><span class="text-muted small" style="padding-left: 30px;">Isi</span></div>
        <div class="col-1"><span class="text-muted small">Edit</span></div>
    </div>

    <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; min-height:84px;">
        <div class="row g-1 align-items-center p-3">
            <div class="col-11 px-3">
                <p class="mb-0 fs-6 limit-1">{!! $organisasis[0]->visi_misi !!}</p>
            </div>
            <div class="col-1">
                <div class="d-flex justify-content-end me-2">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editDeskripsiModal">
                    <i class="fa-solid fa-pen"></i>
                </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Deskripsi -->
    <div class="modal fade" id="editDeskripsiModal" tabindex="-1" aria-labelledby="editDeskripsiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDeskripsiModalLabel">Edit Deskripsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.update_deskripsi', $organisasis[0]->organisasi_id) }}" method="POST" id="editDeskripsiForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Visi Misi</label>
                            <div id="editorDeskripsi" style="height: 300px;">{!! $organisasis[0]->visi_misi !!}</div>
                            <input type="hidden" name="visi_misi" id="visiMisiInput">
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

    <h2 class="fw-bold mb-3" style="color: #233046;">Pengurus</h2>
    <div class="row px-2 mb-3">
       <div class="col-2"><span class="text-muted small" style="padding-left: 30px;">Foto</span></div>
       <div class="col-3"><span class="text-muted small">Nama</span></div>
       <div class="col-6"><span class="text-muted small">Jabatan</span></div>
       <div class="col-1"><span class="text-muted small">Edit</span></div>
    </div>

    <div class="galeri-scroll-container mb-3" style="max-height: calc(100vh - 480px); overflow-y: auto; padding-right: 10px;">
        @forelse($organisasis[0]->cards as $anggota)
        <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; min-height: 70px;">
            <div class="row align-items-center p-2">
                <div class="col-2">
                <div class="d-flex align-items-center justify-content-center" style="padding-right: 50px;">
                    <img src="{{ asset('image/organisasi/' . $anggota->foto) }}" alt="Profile Image" style="width: 45px; height: 45px; object-fit: cover; border-radius: 5px">
                </div>
                </div>
                <div class="col-3">
                <div class="d-flex align-items-center">
                    <p class="mb-0 text-white small text-truncate">{{ $anggota->nama }}</p>
                </div>
                </div>
                <div class="col-6">
                <div class="d-flex align-items-center">
                    <p class="mb-0 text-white small text-truncate">{{ $anggota->jabatan }}</p>
                </div>
                </div>
                <div class="col-1">
                <div class="d-flex justify-content-end me-2">
                    <button class="btn btn-warning me-2 py-1 px-2" data-bs-toggle="modal" data-bs-target="#editAnggotaModal{{ $anggota->organisasi_card_id }}"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.delete_anggota', $anggota->organisasi_card_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
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

        <!-- Modal Edit Anggota -->
        <div class="modal fade" id="editAnggotaModal{{ $anggota->organisasi_card_id }}" tabindex="-1" aria-labelledby="editAnggotaModalLabel{{ $anggota->organisasi_card_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnggotaModalLabel{{ $anggota->organisasi_card_id }}">Edit Pengurus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.update_anggota', $anggota->organisasi_card_id) }}" method="POST" enctype="multipart/form-data" class="isi-konten-form">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row gy-3">
                                <div class="col-12 text-center">
                                    <label class="form-label">Foto</label>
                                    <div class="bg-blue-dark rounded-3 text-center overflow-hidden mx-auto" style="width:213px; height:213px;">
                                        <img src="{{ asset('image/organisasi/' . $anggota->foto) }}" id="previewAnggota{{ $anggota->organisasi_card_id }}" alt="" style="object-fit: cover; width:100%; height:100%;">
                                    </div>
                                    <label for="fotoAnggota{{ $anggota->organisasi_card_id }}" class="btn tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                        <i class="fa-solid fa-upload me-2"></i>Upload Foto
                                    </label>
                                    <input type="file" name="foto" class="d-none" id="fotoAnggota{{ $anggota->organisasi_card_id }}" accept="image/*">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control bg-blue-dark" value="{{ $anggota->nama }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control bg-blue-dark" value="{{ $anggota->jabatan }}" required>
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
        <p class="text-center my-5 text-muted">Belum ada data pengurus.</p>
        @endforelse
    </div>

    <div class="card mb-3 p-2 bottom-0 me-5 btn-tambah-2" data-bs-toggle="modal" data-bs-target="#addAnggotaModal">
        <button class="btn" style="color: white">
            <i class="fa-solid fa-plus me-2"></i>Tambah Pengurus
        </button>
    </div>

    <!-- Modal Add Anggota -->
    <div class="modal fade" id="addAnggotaModal" tabindex="-1" aria-labelledby="addAnggotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAnggotaModalLabel">Tambah Pengurus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="isi-konten-form" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.create_anggota') }}" method="POST" enctype="multipart/form-data" class="isi-konten-form">
                    @csrf
                    <input type="hidden" name="organisasi_id" value="{{ $organisasis[0]->organisasi_id }}" required>
                    <div class="modal-body">
                        <div class="row gy-3">
                            <div class="col-12 text-center">
                                <label class="form-label">Foto</label>
                                <div class="bg-blue-dark rounded-3 text-center d-flex align-items-center justify-content-center mx-auto" style="width:213px; height:213px;">
                                    <img src="" id="previewAnggotaAdd" alt="" class="d-none" style="object-fit: cover; width:100%; height:100%; border-radius: 10px;">
                                    <i class="fa-solid fa-image fa-3x text-muted" id="placeholderIconAnggota"></i>
                                </div>
                                <label for="fotoAnggotaAdd" class="btn tombol-upload mt-2" style="cursor: pointer; width: 213px;">
                                    <i class="fa-solid fa-upload me-2"></i>Upload Foto
                                </label>
                                <input type="file" name="foto" class="d-none" id="fotoAnggotaAdd" accept="image/*" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control bg-blue-dark" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control bg-blue-dark" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Tambah Pengurus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview Mind Map
    const fotoMindMap = document.getElementById('fotoMindMap');
    const previewMindMap = document.getElementById('previewMindMap');

    if (fotoMindMap) {
        fotoMindMap.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewMindMap.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize Quill untuk Deskripsi
    var quillDeskripsi = new Quill('#editorDeskripsi', {
        theme: 'snow'
    });

    // Submit form Deskripsi
    const editDeskripsiForm = document.getElementById('editDeskripsiForm');
    if (editDeskripsiForm) {
        editDeskripsiForm.addEventListener('submit', function(e) {
            document.getElementById('visiMisiInput').value = quillDeskripsi.root.innerHTML;
        });
    }

    // Preview foto untuk Add Anggota
    const fotoAnggotaAdd = document.getElementById('fotoAnggotaAdd');
    const previewAnggotaAdd = document.getElementById('previewAnggotaAdd');
    const placeholderIconAnggota = document.getElementById('placeholderIconAnggota');

    if (fotoAnggotaAdd) {
        fotoAnggotaAdd.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewAnggotaAdd.src = e.target.result;
                    previewAnggotaAdd.classList.remove('d-none');
                    if (placeholderIconAnggota) {
                        placeholderIconAnggota.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Preview foto untuk Edit Anggota
    @foreach($organisasis[0]->cards as $anggota)
    const fotoAnggota{{ $anggota->organisasi_card_id }} = document.getElementById('fotoAnggota{{ $anggota->organisasi_card_id }}');
    const previewAnggota{{ $anggota->organisasi_card_id }} = document.getElementById('previewAnggota{{ $anggota->organisasi_card_id }}');

    if (fotoAnggota{{ $anggota->organisasi_card_id }}) {
        fotoAnggota{{ $anggota->organisasi_card_id }}.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewAnggota{{ $anggota->organisasi_card_id }}.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    @endforeach
});
</script>
@endsection
