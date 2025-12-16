@extends('layouts.admin')

@section('title', 'Kelola Konten')

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

<div class="container mt-2">
    <h2 class="fw-bold mb-3" style="color: 233046;">Header Konten</h2>

    <!-- Header labels -->
    <div class="row px-2 mb-3">
        <div class="col-6"><span class="text-muted small">Header</span></div>
        <div class="col-6"><span class="text-muted small">Sub Header</span></div>
    </div>

    <!-- Single header card containing both Header and Sub Header -->
    <div class="card text-white mb-3" style="border-radius:12px; background-color:#233046; min-height:84px;">
        <div class="row g-1 align-items-center p-3">
            <div class="col-3 px-3">
                <p class="mb-0 fs-6">{{ $konten->judul }}</p>
            </div>
        <div class="col px-3">
            <p class="mb-0 text-white small p-limit-1">{{ $konten->deskripsi }}</p>
        </div>
            <div class="col-auto">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModalHeader">
                    <i class="fa-solid fa-pen"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModalHeader" tabindex="-1" aria-labelledby="editModalHeaderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Konten Header</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.update_konten', $konten->konten_id) }}" method="POST" class="isi-konten-form" id="editFormHeader">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control bg-blue-dark" value="{{ $konten->judul }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control bg-blue-dark" rows="5" required>{{ $konten->deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Header -->
    <div class="row px-2 mb-3">
        <div class="col-1">
            <span class="text-muted small">Icon</span>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-4">
                    <span class="text-muted small">Tujuan</span>
                </div>
                <div class="col">
                    <span class="text-muted small">Deskripsi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten List -->

    @php
        $listItems = (is_object($kontens) && method_exists($kontens, 'skip')) ? $kontens->skip(1) : (is_array($kontens) ? array_slice($kontens, 1) : []);
    @endphp

    @foreach ($listItems as $item)
    <div class="card text-white mb-3" style="border-radius: 12px; background-color: #233046; min-height:84px;">
        <div class="row g-0 align-items-center p-3">
            <div class="col-auto">
                <img src="{{asset('image/icon/' . $item->icon)}}" alt="{{ 'icon ' . $item->judul }}" style="width:40px; height:40px;">
            </div>
            <div class="col-3 px-3">
                <p class="mb-0 fs-6">{{ $item->judul }}</p>
            </div>
            <div class="col px-3">
                <p class="mb-0 text-white small">{{ $item->deskripsi }}</p>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->index }}">
                    <i class="fa-solid fa-pen"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Konten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.update_konten', $item->konten_id) }}" method="POST" class="isi-konten-form" enctype="multipart/form-data" id="editForm{{ $loop->index }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    <div class="bg-blue-dark p-5 rounded-3 align-content-center d-flex justify-content-center position-relative" id="iconPreview{{ $loop->index }}">
                                        <img src="{{ asset('image/icon/' . $item->icon) }}" alt="" id="previewImg{{ $loop->index }}" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="judul" class="form-control bg-blue-dark" value="{{ $item->judul }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control bg-blue-dark" rows="4" required>{{ $item->deskripsi }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label for="iconInput{{ $loop->index }}" class="btn bg-blue-dark mb-0 upload-button">
                            <i class="fa-solid fa-upload me-2"></i>Upload Icon
                        </label>
                        <input type="file" name="icon" class="d-none" id="iconInput{{ $loop->index }}" accept="image/*">
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Icon preview
        const iconInput{{ $loop->index }} = document.getElementById('iconInput{{ $loop->index }}');
        const previewImg{{ $loop->index }} = document.getElementById('previewImg{{ $loop->index }}');

        if (iconInput{{ $loop->index }}) {
            iconInput{{ $loop->index }}.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg{{ $loop->index }}.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
    </script>
    @endforeach

</div>
@endsection
