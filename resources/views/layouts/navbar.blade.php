<nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container-fluid px-3 px-md-4">
        
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white fs-5 me-4" href="{{ route('dashboard') }}">
            <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-3 p-1.5 border border-info border-opacity-25" style="width: 36px; height: 36px;">
                <i class="bi bi-shop fs-5"></i>
            </div>
            <span>POS System</span>
        </a>

        <button class="navbar-toggler border-white border-opacity-25 text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 mt-2 mt-lg-0">
                
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill fs-7 fw-medium text-white-50 text-white-hover {{ Request::is('dashboard*') ? 'active bg-white bg-opacity-10 text-white fw-semibold border border-white border-opacity-10' : '' }}" 
                       aria-current="page" 
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2 me-1.5"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill fs-7 fw-medium text-white-50 text-white-hover {{ Request::is('admin/users*') ? 'active bg-white bg-opacity-10 text-white fw-semibold border border-white border-opacity-10' : '' }}" 
                       href="{{ route('admin.users') }}">
                        <i class="bi bi-people me-1.5"></i> Users
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill fs-7 fw-medium text-white-50 text-white-hover {{ Request::is('produk*') ? 'active bg-white bg-opacity-10 text-white fw-semibold border border-white border-opacity-10' : '' }}" 
                       href="{{ route('produk.index') }}">
                        <i class="bi bi-box-seam me-1.5"></i> Produk
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill fs-7 fw-medium text-white-50 text-white-hover {{ Request::is('penjualan*') ? 'active bg-white bg-opacity-10 text-white fw-semibold border border-white border-opacity-10' : '' }}" 
                       href="{{ route('penjualan.index') }}">
                        <i class="bi bi-cart3 me-1.5"></i> Penjualan
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0 border-top border-lg-0 border-white border-opacity-10 mt-2 mt-lg-0">
                @if(Auth::check())
                    <div class="d-none d-xl-flex align-items-center gap-2 text-white-50 fs-7 pe-2">
                        <i class="bi bi-person-circle fs-6 text-info"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1.5 fs-7 d-flex align-items-center gap-1.5 border-opacity-50">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

<style>
    .fs-7 {
        font-size: 0.875rem;
    }
    .text-white-hover:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>