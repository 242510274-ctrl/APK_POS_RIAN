@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')

@include('layouts.navbar')

<div class="container my-4">

    <div class="mb-4">

        <h1 class="h3">
            Edit Jenis
        </h1>

        <p class="text-muted">
            Perbarui data jenis produk.
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('jenis.update', ['jeni' => $jenis->id]) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


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
                        value="{{ old('nama_jenis', $jenis->nama_jenis) }}"
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
                    >{{ old('deskripsi', $jenis->deskripsi) }}</textarea>

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
                    Update
                </button>

            </form>

        </div>

    </div>

</div>

@endsection