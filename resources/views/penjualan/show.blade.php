@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')



<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">

        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-receipt text-info"></i>
                            <span class="small fw-semibold">Rincian Transaksi</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Detail Penjualan #{{ $sale->id }}</h2>
                        <p class="text-white-50 small mb-0">Informasi lengkap transaksi, data kasir, dan daftar item produk.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 border-opacity-25 fs-7">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        @if(strtoupper($sale->status ?? '') !== 'COMPLETED' && strtoupper($sale->status ?? '') !== 'SELESAI')
                            <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-warning text-dark fw-semibold rounded-pill px-4 py-2 fs-7 border-0 shadow-sm">
                                <i class="bi bi-pencil-square me-1"></i> Edit Transaksi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-file-earmark-text display-1 text-white"></i>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-info-circle text-primary me-2"></i>Informasi Transaksi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2" style="width: 40%;">ID Transaksi</td>
                                        <td class="fw-bold text-dark fs-7 py-2">: #{{ $sale->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Tanggal & Waktu</td>
                                        <td class="fw-semibold text-dark fs-7 py-2">
                                            : {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Status Transaksi</td>
                                        <td class="fs-7 py-2">
                                            <span class="d-inline-flex align-items-center">
                                                : &nbsp;
                                                @php
                                                    $st = strtoupper($sale->status ?? '');
                                                @endphp
                                                @if(in_array($st, ['COMPLETED', 'SELESAI', 'PAID']))
                                                    <span class="badge border border-success-subtle bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                                        COMPLETED
                                                    </span>
                                                @elseif($st === 'OPEN')
                                                    <span class="badge border border-warning-subtle bg-warning-subtle text-warning-emphasis px-3 py-1.5 rounded-pill fw-semibold">
                                                        OPEN
                                                    </span>
                                                @else
                                                    <span class="badge border border-secondary-subtle bg-secondary-subtle text-secondary px-3 py-1.5 rounded-pill fw-semibold">
                                                        {{ $st ?: 'PENDING' }}
                                                    </span>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Metode Pembayaran</td>
                                        <td class="fs-7 py-2">
                                            : <span class="badge bg-light text-dark border px-2.5 py-1 rounded-2 fw-semibold">{{ $sale->metode_pembayaran ?? 'CASH' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Total Pembayaran</td>
                                        <td class="fw-bold text-dark h5 mb-0 py-2">
                                            : <span class="text-success">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-person-badge text-info me-2"></i>Informasi Kasir
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2" style="width: 40%;">Nama Kasir</td>
                                        <td class="fw-bold text-dark fs-7 py-2">: {{ $sale->user->name ?? 'Kasir Tidak Ditemukan' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Email Kasir</td>
                                        <td class="fw-semibold text-dark fs-7 py-2">: {{ $sale->user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary ps-0 fs-7 py-2">Role / Hak Akses</td>
                                        <td class="fs-7 py-2">
                                            : <span class="badge bg-body-tertiary text-secondary border px-2.5 py-1 rounded-pill fw-medium">
                                                {{ $sale->user->role->name ?? 'Pengguna' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-cart-check text-success me-2"></i>Daftar Produk yang Dibeli
                </h5>
            </div>
            <div class="card-body p-0">
                @if(isset($sale->itemPenjualan) && $sale->itemPenjualan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                                <tr>
                                    <th scope="col" class="ps-4 py-3 fw-bold text-start" style="width: 5%;">#</th>
                                    <th scope="col" class="py-3 fw-bold text-start">Nama Produk</th>
                                    <th scope="col" class="py-3 fw-bold text-end">Harga Satuan</th>
                                    <th scope="col" class="py-3 fw-bold text-center" style="width: 15%;">Jumlah (Qty)</th>
                                    <th scope="col" class="pe-4 py-3 fw-bold text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($sale->itemPenjualan as $item)
                                    <tr>
                                        <td class="ps-4 py-3 text-start fs-7 text-secondary">{{ $loop->iteration }}</td>
                                        <td class="py-3 text-start fs-7 fw-semibold text-dark">
                                            {{ $item->produk->nama ?? 'Produk Tidak Ditemukan' }}
                                        </td>
                                        <td class="py-3 text-end fs-7 text-secondary">
                                            Rp {{ number_format($item->harga_satuan ?? ($item->produk->harga_jual ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 text-center fs-7 fw-bold text-dark">
                                            <span class="badge bg-light text-dark border px-3 py-1 rounded-pill">
                                                {{ $item->kuantitas }}
                                            </span>
                                        </td>
                                        <td class="pe-4 py-3 text-end fs-7 fw-bold text-dark">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light-subtle border-top">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold py-3 text-uppercase text-secondary fs-7">
                                        Total Akhir
                                    </td>
                                    <td class="pe-4 py-3 text-end fs-6 fw-bold text-dark">
                                        @php
                                            $totalSum = $sale->itemPenjualan->sum('subtotal');
                                        @endphp
                                        Rp {{ number_format($totalSum, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-cart-x fs-1 opacity-50 d-block mb-2"></i>
                        <span class="small fw-medium">Tidak ada item produk dalam transaksi ini.</span>
                    </div>
                @endif
            </div>
        </div>

        @if(strtoupper($sale->status ?? '') === 'OPEN')
            <div class="d-flex justify-content-end mb-4">
                <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi penjualan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2 fs-7 border-opacity-50">
                        <i class="bi bi-trash me-1"></i> Hapus Penjualan
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>

<style>
    .tracking-wider {
        letter-spacing: 0.06em;
    }
    .fs-7 {
        font-size: 0.85rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

@endsection