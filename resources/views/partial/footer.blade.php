<footer>
    <div class="container-fluid px-5">
        <div class="row align-items-start gx-4">
        <div class="col-md text-center text-md-start mb-4 mb-md-0">
            <img src="{{asset('image/icon/Logo2.png')}}" alt="Logo" width="150">
        </div>

        <div class="col-md mb-4 mb-md-0">
            <h5>Links</h5>
            <ul class="list-unstyled">
            <li class="my-2"><a href="/">Beranda</a></li>
            <li class="my-2"><a href="/#section-content">Galeri</a></li>
            <li class="my-2"><a href="/Organisasi">Organisasi</a></li>
            <li class="my-2"><a href="/Berita">Berita</a></li>
            </ul>
        </div>

        <div class="col-md mb-5 mb-md-0">
            <h5 class="mb-5">Ikuti Kami</h5>
            <div class="social-icons">
            <a href="https://www.instagram.com/dimjengsleman/"><i class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/channel/UCA18wrO_ZeDOQK9xxfOyeSg"><i class="bi bi-youtube"></i></a>
            <a href="https://web.facebook.com/dimjengsleman/?locale=id_ID&_rdc=1&_rdr#"><i class="bi bi-facebook"></i></a>
            </div>
        </div>

        <div class="col-md ps-md-4">
            <h5 class="mb-5">Berlangganan Informasi</h5>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->has('email'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first('email') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            <form action="{{ route('subscribe') }}" method="POST" class="subscribe d-flex">
            @csrf
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit"></button>
            </form>
        </div>
        </div>

        <div class="footer-bottom mt-4">
        Copyright ©2025 <span style="color:#ffd700;">Dimas Diajeng Sleman</span>
        </div>
    </div>
</footer>
