<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    /**
     * Menampilkan halaman POS.
     *
     * Mencari transaksi OPEN milik user yang sedang login.
     * Jika belum ada, maka membuat transaksi baru.
     */
    public function create()
    {
        // Cari transaksi OPEN milik user yang sedang login
        $sale = Penjualan::where('user_id', Auth::id())
            ->where('status', 'OPEN')
            ->latest()
            ->first();

        // Jika belum ada transaksi OPEN, buat transaksi baru
        if (!$sale) {
            $sale = Penjualan::create([
                'user_id'           => Auth::id(),
                'status'            => 'OPEN',
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH',
            ]);
        }

        // Ambil produk berdasarkan pencarian
        $products = Produk::when(request('search'), function ($query) {
            $query->where(
                'nama',
                'like',
                '%' . request('search') . '%'
            );
        })->get();

        // Load item transaksi dan produk
        $sale->load('itemPenjualan.produk');

        return view('penjualan.create', [
            'sale'     => $sale,
            'products' => $products,
        ]);
    }

    /**
     * Menampilkan halaman edit transaksi.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        // Ambil produk berdasarkan pencarian
        $products = Produk::when(request('search'), function ($query) {
            $query->where(
                'nama',
                'like',
                '%' . request('search') . '%'
            );
        })->get();

        // Load item transaksi dan produk
        $sale->load('itemPenjualan.produk');

        return view('penjualan.create', [
            'sale'     => $sale,
            'products' => $products,
        ]);
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id',
            'product_id'   => 'required|exists:produk,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        // Cari transaksi
        $penjualan = Penjualan::findOrFail(
            $request->penjualan_id
        );

        // Pastikan transaksi masih OPEN
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return redirect()
                ->back()
                ->withErrors([
                    'penjualan_id' =>
                        'Transaksi sudah selesai dan tidak dapat diubah.',
                ]);
        }

        // Cari produk
        $produk = Produk::findOrFail(
            $request->product_id
        );

        // Ambil harga jual produk
        $hargaSatuan = $produk->harga_jual;

        // Pastikan harga jual tidak NULL
        if ($hargaSatuan === null) {
            return redirect()
                ->back()
                ->withErrors([
                    'product_id' =>
                        'Harga jual produk "' .
                        $produk->nama .
                        '" belum diisi.',
                ]);
        }

        // Ambil quantity dari form
        $kuantitas = (int) $request->quantity;

        /*
        |--------------------------------------------------------------------------
        | Simpan item
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $penjualan,
            $produk,
            $hargaSatuan,
            $kuantitas
        ) {
            // Cek apakah produk sudah ada di keranjang
            $item = ItemPenjualan::where(
                'penjualan_id',
                $penjualan->id
            )
                ->where('produk_id', $produk->id)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | PRODUK SUDAH ADA DI KERANJANG
            |--------------------------------------------------------------------------
            */
            if ($item) {

                $kuantitasLama = (int) $item->kuantitas;

                $kuantitasBaru = $kuantitasLama + $kuantitas;

                $subtotalLama = (float) $item->subtotal;

                $subtotalBaru = $hargaSatuan * $kuantitasBaru;

                // Selisih total pembayaran
                $selisih = $subtotalBaru - $subtotalLama;

                // Update item
                $item->update([
                    'kuantitas'    => $kuantitasBaru,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal'     => $subtotalBaru,
                ]);

                // Update total transaksi
                $penjualan->increment(
                    'total_pembayaran',
                    $selisih
                );
            }

            /*
            |--------------------------------------------------------------------------
            | PRODUK BELUM ADA DI KERANJANG
            |--------------------------------------------------------------------------
            */
            else {

                $subtotal = $hargaSatuan * $kuantitas;

                // Simpan item baru
                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id'    => $produk->id,
                    'kuantitas'    => $kuantitas,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal'     => $subtotal,
                ]);

                // Tambahkan subtotal ke total pembayaran
                $penjualan->increment(
                    'total_pembayaran',
                    $subtotal
                );
            }
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Produk berhasil ditambahkan ke keranjang!'
            );
    }

    /**
     * Mengubah jumlah/kuantitas item.
     */
    public function update(
        Request $request,
        ItemPenjualan $itempenjualan
    ) {
        // Validasi quantity
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $kuantitasBaru = (int) $request->quantity;

        // Ambil harga satuan
        $hargaSatuan = (float) $itempenjualan->harga_satuan;

        // Ambil subtotal lama
        $subtotalLama = (float) $itempenjualan->subtotal;

        // Hitung subtotal baru
        $subtotalBaru = $hargaSatuan * $kuantitasBaru;

        // Hitung selisih
        $selisih = $subtotalBaru - $subtotalLama;

        DB::transaction(function () use (
            $itempenjualan,
            $kuantitasBaru,
            $subtotalBaru,
            $selisih
        ) {
            // Update item
            $itempenjualan->update([
                'kuantitas' => $kuantitasBaru,
                'subtotal'  => $subtotalBaru,
            ]);

            // Cari transaksi
            $penjualan = Penjualan::findOrFail(
                $itempenjualan->penjualan_id
            );

            // Update total pembayaran
            $penjualan->increment(
                'total_pembayaran',
                $selisih
            );
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Jumlah produk berhasil diperbarui.'
            );
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(
        ItemPenjualan $itempenjualan
    ) {
        // Ambil subtotal item
        $subtotal = (float) $itempenjualan->subtotal;

        // Cari transaksi induk
        $penjualan = Penjualan::findOrFail(
            $itempenjualan->penjualan_id
        );

        DB::transaction(function () use (
            $itempenjualan,
            $penjualan,
            $subtotal
        ) {
            // Kurangi total pembayaran
            $penjualan->decrement(
                'total_pembayaran',
                $subtotal
            );

            // Hapus item
            $itempenjualan->delete();
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Produk berhasil dihapus dari keranjang.'
            );
    }
}
