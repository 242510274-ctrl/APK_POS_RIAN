@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')

@include('layouts.navbar')

<div class="container my-4">

    <div class="mb-4">

        <h1 class="h3">
            Tambah Jenis
        </h1>

        <p class="text-muted">
            Tambahkan jenis produk baru.
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('jenis.store') }}"
                method="POST"
            >

                @csrf


                <div class="mb-3">

                    <label
                        for="nama_jenis"
                        class="form-label"
                    >
                        Nama Jenis
                    </label>

                    <input
                        type="text"
                        name="nama_jenis"
                        id="nama_jenis"
                        class="form-control @error('nama_jenis') is-invalid @enderror"
                        value="{{ old('nama_jenis') }}"
                        placeholder="Contoh: Makanan"
                    >

                    @error('nama_jenis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="deskripsi"
                        class="form-label"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        rows="4"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Masukkan deskripsi jenis..."
                    >{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <a
                    href="{{ route('jenis.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan
                </button>

            </form>

        </div>

    </div>

</div>

@endsection