    <div class="sidebar">
        <h4><i class="fa-solid fa-user"></i> Admin</h4>
        <p class="sidebar-section-title">Main Menu</p>

        <a href="{{ route('admin.index') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house me-2"></i>Dashboard Admin
        </a>
        <a href="{{ route('admin.kelola_konten') }}" class="{{ request()->is('admin/kelola-konten') ? 'active' : '' }}">
        <i class="fa-solid fa-file-lines me-2"></i>Kelola Konten
        </a>
        <a href="{{  route('admin.kelola_galeri') }}" class="{{ request()->is('admin/kelola-galeri') ? 'active' : '' }}">
        <i class="fa-solid fa-image me-2"></i>Kelola Galeri</a>
        <a href="{{ route('admin.kelola_organisasi') }}" class="{{ request()->is('admin/kelola-organisasi') ? 'active' : '' }}"><i class="fa-solid fa-users me-2"></i>Kelola Organisasi</a>
        <a href="{{ route('admin.kelola_berita') }}" class="{{ request()->is('admin/kelola-berita') ? 'active' : ''}}"><i class="fa-solid fa-newspaper me-2"></i>Kelola Berita</a>
        <a href="{{ route('admin.email_berlangganan') }}" class="{{ request()->is('admin/email-berlangganan') ? 'active' : ''}}"><i class="fa-solid fa-envelope me-2"></i>Email Berlangganan</a>
        <a href="{{ route('admin.kirim_informasi') }}" class="{{ request()->is('admin/kirim-informasi') ? 'active' : ''}}"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Informasi</a>

        <p class="sidebar-section-title mt-4">Others</p>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link text-danger p-0"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
        </form>
    </div>
