@extends('layouts.app')

@section('title', 'Jenis')

@section('content')

@include('layouts.navbar')

<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Daftar Jenis
            </h1>

            <p class="text-muted mb-0">
                Kelola jenis produk
            </p>
        </div>

        <a href="{{ route('jenis.create') }}"
           class="btn btn-primary">
            + Tambah Jenis
        </a>

    </div>


    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- Pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            {{-- Search --}}
            <form
                action="{{ route('jenis.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari jenis..."
                        value="{{ request('search') }}"
                    >

                    <button
                        type="submit"
                        class="btn btn-outline-primary"
                    >
                        Cari
                    </button>

                </div>

            </form>


            {{-- Tabel --}}
            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

                        <tr>

                            <th width="70">
                                No
                            </th>

                            <th>
                                Nama Jenis
                            </th>

                            <th>
                                Deskripsi
                            </th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($jenis as $item)

                            <tr>

                                <td>
                                    {{ $jenis->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $item->nama_jenis }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $item->deskripsi ?: '-' }}
                                </td>

                                <td>

                                    <a
                                        href="{{ route('jenis.edit', ['jeni' => $item->id]) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('jenis.destroy', ['jeni' => $item->id]) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus jenis ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-4"
                                >
                                    Belum ada data jenis.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="mt-3">
                {{ $jenis->links() }}
            </div>

        </div>

    </div>

</div>

@endsection