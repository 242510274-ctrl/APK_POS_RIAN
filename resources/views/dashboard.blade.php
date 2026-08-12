@extends('layouts.app')

@section('title', 'Dashboard Performance')

@section('content')

@include('layouts.navbar')

<div class="bg-body-tertiary min-vh-100 py-3 py-md-4 w-100">
    <div class="container-fluid px-3 px-md-4">
        
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 position-relative z-1 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-light mb-2 border border-white border-opacity-10">
                            <i class="bi bi-speedometer2 text-info"></i>
                            <span class="small fw-semibold">Live POS Analytics</span>
                        </div>
                        <h2 class="h3 fw-bold mb-1 text-white">Ringkasan Penjualan</h2>
                        <p class="text-white-50 small mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-check text-info"></i>
                            <span>{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</span>
                        </p>
                    </div>
                    <div>
                        <span class="badge bg-info bg-opacity-25 text-info px-3 py-2 rounded-pill fw-semibold border border-info border-opacity-25">
                            <i class="bi bi-dot"></i> System Online
                        </span>
                    </div>
                </div>
            </div>
            <div class="position-absolute end-0 bottom-0 opacity-10 me-n3 mb-n3 d-none d-md-block" style="pointer-events: none;">
                <i class="bi bi-graph-up-arrow display-1 text-white"></i>
            </div>
        </div>

        @can('viewAny', App\Models\User::class)
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100 hover-lift overflow-hidden">
                        <div class="card-body p-3 p-md-4 d-flex align-items-center">
                            <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 me-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-wallet2 fs-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted d-block small text-uppercase fw-bold tracking-wider mb-1" style="font-size: 0.68rem;">Total Penjualan</span>
                                <h4 class="fw-bold text-dark mb-0 text-truncate fs-5 fs-md-4">
                                    Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100 hover-lift overflow-hidden">
                        <div class="card-body p-3 p-md-4 d-flex align-items-center">
                            <div class="rounded-4 bg-success bg-opacity-10 text-success p-3 me-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-receipt fs-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted d-block small text-uppercase fw-bold tracking-wider mb-1" style="font-size: 0.68rem;">Jumlah Transaksi</span>
                                <h4 class="fw-bold text-dark mb-0 text-truncate fs-5 fs-md-4">
                                    {{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Trx</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100 hover-lift overflow-hidden">
                        <div class="card-body p-3 p-md-4 d-flex align-items-center">
                            <div class="rounded-4 bg-info bg-opacity-10 text-info p-3 me-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-cash-stack fs-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted d-block small text-uppercase fw-bold tracking-wider mb-1" style="font-size: 0.68rem;">Tunai (Cash)</span>
                                <h4 class="fw-bold text-dark mb-0 text-truncate fs-5 fs-md-4">
                                    Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100 hover-lift overflow-hidden">
                        <div class="card-body p-3 p-md-4 d-flex align-items-center">
                            <div class="rounded-4 bg-warning bg-opacity-10 text-warning p-3 me-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-qr-code-scan fs-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted d-block small text-uppercase fw-bold tracking-wider mb-1" style="font-size: 0.68rem;">Non-Tunai (QRIS/Transfer)</span>
                                <h4 class="fw-bold text-dark mb-0 text-truncate fs-5 fs-md-4">
                                    Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-3">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Stok Menipis</h6>
                        </div>
                        <span class="badge border border-warning-subtle bg-warning-subtle text-warning-emphasis px-2.5 py-1 rounded-pill small fw-semibold">Warning</span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="py-2.5 fw-bold">#</th>
                                        <th scope="col" class="py-2.5 fw-bold">Nama Produk</th>
                                        <th scope="col" class="py-2.5 fw-bold text-end">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($produkStokRendah as $index => $produk)
                                        <tr>
                                            <td class="text-muted py-3 fs-7">{{ $produkStokRendah->firstItem() + $index }}</td>
                                            <td class="fw-bold text-dark py-3">{{ $produk->nama }}</td>
                                            <td class="text-end py-3">
                                                <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-1.5 rounded-pill fw-semibold">
                                                    {{ $produk->stok }} unit
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center py-4">
                                                <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-1"></i>
                                                <span class="small fw-medium">Semua stok produk masih mencukupi.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($produkStokRendah->hasPages())
                            <div class="mt-3 pt-2 border-top border-light">
                                {{ $produkStokRendah->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 bg-danger bg-opacity-10 text-danger rounded-3">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Stok Habis</h6>
                        </div>
                        <span class="badge border border-danger-subtle bg-danger-subtle text-danger px-2.5 py-1 rounded-pill small fw-semibold">Critical</span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="py-2.5 fw-bold">#</th>
                                        <th scope="col" class="py-2.5 fw-bold">Nama Produk</th>
                                        <th scope="col" class="py-2.5 fw-bold text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($produkStokHabis as $index => $produk)
                                        <tr>
                                            <td class="text-muted py-3 fs-7">{{ $produkStokHabis->firstItem() + $index }}</td>
                                            <td class="fw-bold text-dark py-3">{{ $produk->nama }}</td>
                                            <td class="text-end py-3">
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                                    Habis
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center py-4">
                                                <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-1"></i>
                                                <span class="small fw-medium">Tidak ada produk yang habis.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($produkStokHabis->hasPages())
                            <div class="mt-3 pt-2 border-top border-light">
                                {{ $produkStokHabis->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-success bg-opacity-10 text-success rounded-3">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-0">Produk Terlaris Hari Ini</h6>
                </div>
                <span class="badge border border-success-subtle bg-success-subtle text-success px-2.5 py-1 rounded-pill small fw-semibold">Top Performers</span>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle text-secondary small text-uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="py-2.5 fw-bold">Nama Produk</th>
                                <th scope="col" class="py-2.5 fw-bold">Stok Tersisa</th>
                                <th scope="col" class="py-2.5 fw-bold text-end">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($produkTerlaris as $index => $produk)
                                <tr>
                                    <td class="fw-bold text-dark py-3">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar-circle rounded-circle bg-dark bg-opacity-10 text-dark fw-bold d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                                {{ $loop->iteration }}
                                            </span>
                                            {{ $produk->nama }}
                                        </div>
                                    </td>
                                    <td class="py-3 text-secondary">{{ $produk->stok }} unit</td>
                                    <td class="text-end py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fw-bold">
                                            <i class="bi bi-graph-up me-1"></i>{{ $produk->total_terjual }} Terjual
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-4">
                                        <i class="bi bi-inbox text-muted fs-2 d-block mb-1 opacity-50"></i>
                                        <span class="small fw-medium">Belum ada transaksi penjualan tercatat hari ini.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }
    .tracking-wider {
        letter-spacing: 0.06em;
    }
    .fs-7 {
        font-size: 0.825rem;
    }
</style>

@endsection