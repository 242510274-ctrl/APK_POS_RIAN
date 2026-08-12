@extends('layouts.app')

@section('title', 'POS - Kasir Penjualan')

@section('content')

@include('layouts.navbar')

<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">

        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-calculator text-info"></i>
                            <span class="small fw-semibold">Point of Sale</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">
                            {{ isset($sale->id) ? 'Edit Transaksi Penjualan' : 'Transaksi Penjualan Baru' }}
                        </h2>
                        <p class="text-white-50 small mb-0">Pilih item produk dan selesaikan transaksi kasir dengan cepat.</p>
                    </div>
                    <div>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 border-opacity-25 fs-7">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-cart-dash display-1 text-white"></i>
            </div>
        </div>

        <div class="row g-4">

            {{-- ---------------- BAGIAN KATALOG PRODUK ---------------- --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-boxes text-primary me-2"></i>Katalog Produk
                            </h5>
                            <span class="badge bg-light text-secondary border rounded-pill px-3 py-1">
                                {{ count($products) }} Produk Ditemukan
                            </span>
                        </div>

                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <div class="input-group rounded-pill overflow-hidden bg-body-tertiary border border-light-subtle">
                                <span class="input-group-text bg-transparent border-0 ps-3 text-secondary">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    class="form-control bg-transparent border-0 ps-2 fs-7 shadow-none text-dark" 
                                    placeholder="Cari produk..."
                                    onkeyup="this.form.submit()"
                                >
                                @if(request('search'))
                                    <a href="{{ route('penjualan.create') }}" class="btn bg-transparent border-0 text-secondary pe-2">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="card-body p-3 p-md-4" style="max-height: 65vh; overflow-y: auto;">
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="card border rounded-3 hover-shadow-sm transition-all bg-light-subtle">
                                        <div class="card-body p-2 p-md-3">
                                            <div class="row g-2 align-items-center">
                                                <div class="col-6 col-md-7">
                                                    <div class="fw-bold text-dark text-truncate fs-7" title="{{ $product->nama }}">
                                                        {{ $product->nama }}
                                                    </div>
                                                    <div class="small text-muted fw-semibold">
                                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                                    </div>
                                                </div>

                                                <div class="col-3 col-md-3">
                                                    <input 
                                                        type="number" 
                                                        name="quantity" 
                                                        value="1" 
                                                        min="1"
                                                        class="form-control form-control-sm border-light-subtle text-center rounded-3 fs-7"
                                                    >
                                                </div>

                                                <div class="col-3 col-md-2">
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-sm btn-dark w-100 rounded-3 d-flex align-items-center justify-content-center py-1.5 {{ isset($sale->status) && in_array(strtoupper($sale->status), ['COMPLETED', 'SELESAI', 'PAID']) ? 'disabled' : '' }}"
                                                        title="Tambah ke Keranjang"
                                                    >
                                                        <i class="bi bi-plus-lg fs-6"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 opacity-50 d-block mb-2"></i>
                                <span class="small fw-medium">Produk tidak ditemukan.</span>
                            </div>
                        @endif
                    </div> 
                </div>
            </div>

            {{-- ===================== BAGIAN KERANJANG BELANJA ===================== --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden d-flex flex-column">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-cart3 text-info me-2"></i>Keranjang Transaksi
                            </h5>
                            @if(isset($sale->status))
                                @php
                                    $st = strtoupper($sale->status);
                                @endphp
                                @if(in_array($st, ['COMPLETED', 'SELESAI', 'PAID']))
                                    <span class="badge border border-success-subtle bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                        Status: Selesai
                                    </span>
                                @else
                                    <span class="badge border border-warning-subtle bg-warning-subtle text-warning-emphasis px-3 py-1.5 rounded-pill fw-semibold">
                                        Status: {{ ucfirst($sale->status) }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-0 flex-grow-1" style="max-height: 45vh; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="ps-4 py-3 fw-bold text-start">Produk</th>
                                        <th scope="col" class="py-3 fw-bold text-start">Harga</th>
                                        <th scope="col" class="py-3 fw-bold text-start" style="width: 15%;">Qty</th>
                                        <th scope="col" class="py-3 fw-bold text-start">Subtotal</th>
                                        <th scope="col" class="pe-4 py-3 fw-bold text-start" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="border-top-0">
                                    @if(isset($sale->itemPenjualan) && count($sale->itemPenjualan) > 0)
                                        @foreach($sale->itemPenjualan as $item)
                                            <tr>
                                                <td class="ps-4 py-3 text-start fs-7 fw-semibold text-dark">
                                                    {{ $item->produk->nama ?? 'Produk Tidak Ditemukan' }}
                                                </td>
                                                <td class="py-3 text-start fs-7 text-secondary">
                                                    Rp {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}
                                                </td>

                                                <td class="py-3 text-start">
                                                    <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                        @csrf 
                                                        @method('PUT')
                                                        <input 
                                                            type="number"
                                                            name="quantity"
                                                            value="{{ $item->kuantitas }}"
                                                            min="1"
                                                            onchange="this.form.submit()"
                                                            class="form-control form-control-sm border-light-subtle rounded-3 text-center fs-7"
                                                            style="width: 60px;"
                                                        >
                                                    </form>
                                                </td>

                                                <td class="py-3 text-start fs-7 fw-bold text-dark">
                                                    Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                                                </td>

                                                <td class="pe-4 py-3 text-start">
                                                    @can('delete', $item)
                                                    <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light border text-danger rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus Item">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5">
                                                <i class="bi bi-cart-x fs-1 opacity-50 d-block mb-2"></i>
                                                <span class="small fw-medium">Keranjang transaksi masih kosong.</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-semibold">Total Pembayaran:</span>
                            <span class="h4 fw-bold text-dark mb-0">
                                Rp {{ number_format($sale->total_pembayaran ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- FORM CHECKOUT --}}
                        <form method="POST"
                              action="{{ route('penjualan.update', $sale->id ?? 0) }}"
                              onsubmit="return confirm('Yakin ingin menyelesaikan transaksi ini?')" 
                              class="mb-2">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Metode Pembayaran</label>
                                <select name="payment_method" class="form-select rounded-pill border-light-subtle fs-7" required>
                                    <option value="">-- Pilih Pembayaran --</option>
                                    <option value="CASH" {{ (isset($sale->metode_pembayaran) && strtoupper($sale->metode_pembayaran) == 'CASH') ? 'selected' : '' }}>Cash / Tunai</option>
                                    <option value="QRIS" {{ (isset($sale->metode_pembayaran) && strtoupper($sale->metode_pembayaran) == 'QRIS') ? 'selected' : '' }}>QRIS</option>
                                    <option value="TRANSFER" {{ (isset($sale->metode_pembayaran) && strtoupper($sale->metode_pembayaran) == 'TRANSFER') ? 'selected' : '' }}>Transfer Bank</option>
                                </select>
                            </div>

                            @php
                                $isDisableCheckout = !isset($sale->itemPenjualan) || $sale->itemPenjualan->count() == 0 || (isset($sale->status) && in_array(strtoupper($sale->status), ['COMPLETED', 'SELESAI', 'PAID']));
                            @endphp

                            <button type="submit" class="btn btn-info w-100 fw-bold text-dark rounded-pill py-2.5 border-0 shadow-sm {{ $isDisableCheckout ? 'disabled' : '' }}">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesaikan & Checkout
                            </button>
                        </form>

                        {{-- FORM BATALKAN TRANSAKSI --}}
                        @if(isset($sale) && $sale->id)
                            @can('delete', $sale)
                            <form action="{{ route('penjualan.destroy', $sale->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')"
                                  class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fs-7 border-opacity-50 {{ (isset($sale->status) && in_array(strtoupper($sale->status), ['COMPLETED', 'SELESAI', 'PAID'])) ? 'disabled' : '' }}">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Transaksi
                                </button>
                            </form>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>

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
    .transition-all {
        transition: all 0.2s ease;
    }
    .hover-shadow-sm:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        border-color: #cbd5e1 !important;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

@endsection