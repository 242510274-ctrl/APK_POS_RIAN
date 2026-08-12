@extends('layouts.app')

@section('title', 'Detail Produk - ' . $produk->nama)

@section('content')

@include('layouts.navbar')

<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">
        
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-box-seam text-info"></i>
                            <span class="small fw-semibold">Inventory Detail</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Detail Produk</h2>
                        <p class="text-white-50 small mb-0">Informasi lengkap spesifikasi, harga, dan ketersediaan stok barang.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fs-7">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                        @can('update', $produk)
                        <a href="{{ route('produk.edit', $produk) }}" class="btn btn-info fw-bold text-dark shadow-sm rounded-pill px-4 py-2 border-0 fs-7">
                            <i class="bi bi-pencil-fill me-1"></i> Edit Produk
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-box2 display-1 text-white"></i>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-body p-4">
                <div class="row g-4">
                    
                    <div class="col-12 col-md-5 col-lg-4 text-center">
                        <div class="p-3 bg-body-tertiary rounded-4 border d-flex align-items-center justify-content-center" style="min-height: 280px;">
                            @if(!empty($produk->foto))
                                <img src="{{ asset('storage/' . $produk->foto) }}" 
                                     alt="{{ $produk->nama }}" 
                                     class="img-fluid rounded-3 shadow-sm object-fit-cover w-100" 
                                     style="max-height: 320px; object-fit: contain;">
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i>
                                    <span class="small fw-medium">Tidak ada foto produk</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-7 col-lg-8">
                        <div class="d-flex flex-column h-100 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-secondary-subtle text-secondary border px-3 py-1.5 rounded-pill fs-7">
                                        ID Produk: #{{ $produk->id }}
                                    </span>
                                    
                                    <div>
                                        @if(($produk->stok ?? 0) > 10)
                                            <span class="badge border border-success-subtle bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Stok Melimpah ({{ $produk->stok }})
                                            </span>
                                        @elseif(($produk->stok ?? 0) > 0)
                                            <span class="badge border border-warning-subtle bg-warning-subtle text-warning-emphasis px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Stok Menipis ({{ $produk->stok }})
                                            </span>
                                        @else
                                            <span class="badge border border-danger-subtle bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-x-circle-fill me-1"></i> Stok Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <h3 class="fw-bold text-dark mb-3">{{ $produk->nama }}</h3>

                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="p-3 rounded-3 bg-body-tertiary border">
                                            <small class="text-muted d-block mb-1 fs-7">Harga Beli</small>
                                            <span class="fs-5 fw-bold text-secondary">
                                                Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="p-3 rounded-3 bg-dark text-white border">
                                            <small class="text-white-50 d-block mb-1 fs-7">Harga Jual</small>
                                            <span class="fs-4 fw-bold text-info">
                                                Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="row g-2 text-secondary fs-7">
                                        <div class="col-4 col-sm-3 fw-semibold">Ditambahkan oleh</div>
                                        <div class="col-8 col-sm-9 text-dark">
                                            <i class="bi bi-person-circle me-1 text-muted"></i>
                                            {{ $produk->user->name ?? '-' }}
                                        </div>

                                        <div class="col-4 col-sm-3 fw-semibold">Tanggal Input</div>
                                        <div class="col-8 col-sm-9 text-dark">
                                            {{ $produk->created_at ? $produk->created_at->translatedFormat('d F Y, H:i') : '-' }}
                                        </div>

                                        <div class="col-4 col-sm-3 fw-semibold">Terakhir Diperbarui</div>
                                        <div class="col-8 col-sm-9 text-dark">
                                            {{ $produk->updated_at ? $produk->updated_at->translatedFormat('d F Y, H:i') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 mt-3 border-top d-flex justify-content-end align-items-center gap-2">
                                @can('delete', $produk)
                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fs-7" 
                                            onclick="return confirm('Apakah Anda yakin akan menghapus produk ini?')">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus Produk
                                    </button>
                                </form>
                                @endcan
                            </div>

                        </div>
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