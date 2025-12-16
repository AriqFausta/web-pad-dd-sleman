<nav class="navbar navbar-expand-lg navbar-dark bg-blue-dark">
  <div class="container">
    <img src="{{asset('image/icon/Logo2.png')}}" alt="Logo Dimas Diajeng" class="navbar-logo me-3">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('galeri*') ? 'active' : '' }}" href="/#section-content">Galeri</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('Organisasi') ? 'active' : '' }}" href="/Organisasi">Organisasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('Berita*') ? 'active' : '' }}" href="/Berita">Berita</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
