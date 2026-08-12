@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

@include('layouts.navbar')

<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">
        
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-person-plus-fill text-info"></i>
                            <span class="small fw-semibold">User Management</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Tambah User Baru</h2>
                        <p class="text-white-50 small mb-0">Daftarkan pengguna baru untuk memberikan hak akses ke dalam sistem POS.</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fs-7">
                            <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-person-gear display-1 text-white"></i>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white border-bottom border-light-subtle py-3 px-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-vcard text-info fs-5"></i>
                            <h5 class="card-title fw-bold text-dark mb-0 fs-6">Formulir Pendaftaran User</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            @include('users._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .fs-7 {
        font-size: 0.85rem;
    }
</style>

@endsection