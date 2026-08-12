@extends('layouts.app')

@section('title', 'Produk')

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
                            <span class="small fw-semibold">Inventory & Catalog</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Halaman Produk</h2>
                        <p class="text-white-50 small mb-0">Kelola daftar produk, harga beli, harga jual, dan persediaan stok.</p>
                    </div>
                    <div>
                        @can('create', App\Models\Produk::class)
                        <a href="{{ route('produk.create') }}" class="btn btn-info fw-bold text-dark shadow-sm rounded-pill px-4 py-2 border-0">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-boxes display-1 text-white"></i>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-12 col-md-6 col-lg-4">
                        <form action="{{ route('produk.index') }}" method="GET">
                            <div class="input-group rounded-pill overflow-hidden bg-body-tertiary border border-light-subtle">
                                <span class="input-group-text bg-transparent border-0 ps-3 text-secondary">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 ps-2 fs-7 shadow-none text-dark" placeholder="Search nama produk">
                                @if(request('search'))
                                    <a href="{{ route('produk.index') }}" class="btn bg-transparent border-0 text-secondary pe-2">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                                <button class="btn btn-dark px-4 fw-semibold fs-7 border-0" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-12 col-md-auto text-secondary small fw-medium">
                        <span class="d-inline-block px-3 py-1 rounded-pill bg-light-subtle border">
                            <i class="bi bi-box-seam-fill me-1 text-primary"></i> Total Produk: <strong class="text-dark">{{ method_exists($products, 'total') ? $products->total() : count($products) }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="ps-4 py-3 fw-bold" style="width: 5%;">#</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 15%;">User</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 10%;">Foto</th>
                                <th scope="col" class="py-3 fw-bold text-start" style="width: 20%;">Nama</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 10%;">Harga Beli</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 10%;">Harga Jual</th>
                                <th scope="col" class="py-3 fw-bold" style="width: 10%;">Stok</th>
                                <th scope="col" class="pe-4 py-3 fw-bold" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
@if(count($products) > 0)
@foreach($products as $product)
                            <tr>
                                <td class="ps-4 text-muted py-3 fs-7">
                                    {{ method_exists($products, 'firstItem') ? $products->firstItem() + $loop->index : $loop->iteration }}
                                </td>
                                <td class="py-3 text-secondary fs-7">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bi bi-person-circle text-muted"></i>
                                        <span>{{ $product->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if(!empty($product->foto))
                                        <img src="{{ asset('storage/'.$product->foto) }}" alt="{{ $product->nama }}" width="70" class="img-thumbnail rounded-3 shadow-sm object-fit-cover">
                                    @else
                                        <div class="rounded-3 bg-light border d-inline-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                            <i class="bi bi-image fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-start py-3 fw-semibold text-dark fs-7">
                                    {{ $product->nama }}
                                </td>
                                <td class="py-3 text-secondary fs-7">
                                    Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="py-3 text-dark fw-bold fs-7">
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="align-middle py-3">
                                    @if(($product->stok ?? 0) > 10)
                                        <span class="badge border border-success-subtle bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                            {{ $product->stok }}
                                        </span>
                                    @elseif(($product->stok ?? 0) > 0)
                                        <span class="badge border border-warning-subtle bg-warning-subtle text-warning-emphasis px-3 py-1.5 rounded-pill fw-semibold">
                                            {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="badge border border-danger-subtle bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3">
                                    <div class="d-flex gap-1 justify-content-center align-items-center">
                                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-sm btn-light border text-info-emphasis hover-action-btn rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Detail Produk">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        @can('update', $product)
                                        <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-light border text-warning-emphasis hover-action-btn rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Edit Produk">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        @endcan

                                        @can('delete', $product)
                                        <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger hover-action-btn rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" onclick="return confirm('Apakah Anda yakin akan menghapus produk ini?')" title="Hapus Produk">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
@endforeach
@else
                            <tr>
                                <td colspan="8" class="text-muted text-center py-5">
                                    <i class="bi bi-box-seam text-muted fs-1 d-block mb-2 opacity-50"></i>
                                    <span class="small fw-medium">Tidak ada data produk ditemukan.</span>
                                </td>
                            </tr>
@endif
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $products->links() }}
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
    .hover-action-btn {
        transition: all 0.2s ease;
    }
    .hover-action-btn:hover {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        transform: translateY(-2px);
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

@endsection