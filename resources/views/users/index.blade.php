@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')

@include('layouts.navbar')

<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">
        
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-people text-info"></i>
                            <span class="small fw-semibold">Access Control & Security</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Daftar Pengguna Sistem</h2>
                        <p class="text-white-50 small mb-0">Kelola hak akses, peranan, dan profil pengguna aplikasi POS.</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-info fw-bold text-dark shadow-sm rounded-pill px-4 py-2 border-0">
                            <i class="bi bi-person-plus-fill me-1"></i> Tambah User Baru
                        </a>
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-person-badge display-1 text-white"></i>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-12 col-md-6 col-lg-4">
                        <form action="{{ route('admin.users') }}" method="GET">
                            <div class="input-group rounded-pill overflow-hidden bg-body-tertiary border border-light-subtle">
                                <span class="input-group-text bg-transparent border-0 ps-3 text-secondary">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    class="form-control bg-transparent border-0 ps-2 fs-7 shadow-none text-dark" 
                                    placeholder="Cari nama pengguna atau email..."
                                >
                                @if(request('search'))
                                    <a href="{{ route('admin.users') }}" class="btn bg-transparent border-0 text-secondary pe-2">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                                <button class="btn btn-dark px-4 fw-semibold fs-7 border-0" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-12 col-md-auto text-secondary small fw-medium">
                        <span class="d-inline-block px-3 py-1 rounded-pill bg-light-subtle border">
                            <i class="bi bi-person-lines-fill me-1 text-primary"></i> Total User: <strong class="text-dark">{{ method_exists($users, 'total') ? $users->total() : count($users) }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="ps-4 py-3 fw-bold" style="width: 5%;">#</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 30%;">Pengguna</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 30%;">Email</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 20%;">Peran (Role)</th>
                                <th scope="col" class="pe-4 py-3 fw-bold text-end" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="ps-4 text-muted py-3 fs-7">
                                        {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                                    </td>

                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0 fs-7">{{ $user->name ?? '-' }}</h6>
                                                <span class="text-secondary style-subtext">ID: #{{ $user->id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3 text-secondary fs-7">
                                        <i class="bi bi-envelope me-1 text-muted"></i>{{ $user->email ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        @php
                                            $roleName = 'User';
                                            if (is_object($user->role ?? null)) {
                                                $roleName = $user->role->name ?? $user->role->nama_role ?? 'User';
                                            } elseif (is_string($user->role ?? null)) {
                                                $roleName = $user->role;
                                            }
                                        @endphp
                                        <span class="badge border border-primary-subtle bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-semibold">
                                            {{ ucfirst($roleName) }}
                                        </span>
                                    </td>

                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-light border text-warning-emphasis hover-action-btn rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                                               style="width: 36px; height: 36px;" 
                                               title="Edit User">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-light border text-danger hover-action-btn rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                                                        style="width: 36px; height: 36px;" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" 
                                                        title="Hapus User">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted text-center py-5">
                                        <i class="bi bi-people text-muted fs-1 d-block mb-2 opacity-50"></i>
                                        <span class="small fw-medium">Tidak ada data pengguna ditemukan.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($users, 'hasPages') && $users->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    .tracking-wider {
        letter-spacing: 0.06em;
    }
    .fs-7 {
        font-size: 0.85rem;
    }
    .style-subtext {
        font-size: 0.75rem;
    }
    .hover-action-btn {
        transition: all 0.2s ease;
    }
    .hover-action-btn:hover {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        transform: translateY(-2px);
    }
</style>

@endsection