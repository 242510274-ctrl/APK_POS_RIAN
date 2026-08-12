<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Halaman POS untuk TRANSAKSI BARU (Keranjang Harus Kosong)
     */
    public function create()
    {
        // 1. Buat Draf Transaksi Baru Khusus untuk Sesi Ini
        $sale = Penjualan::create([
            'user_id'          => Auth::id(),
            'status'           => 'OPEN',
            'total_pembayaran' => 0,
            'metode_pembayaran' => 'CASH',
        ]);

        // 2. Ambil Daftar Produk
        $products = Produk::when(request('search'), function ($query) {
            $query->where('nama', 'like', '%' . request('search') . '%');
        })->get();

        // 3. Tampilkan view dengan $sale BARU yang belum ada itemnya
        return view('penjualan.create', compact('sale', 'products'));
    }

    /**
     * Halaman POS untuk EDIT TRANSAKSI LAMA
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;
        
        $products = Produk::when(request('search'), function ($query) {
            $query->where('nama', 'like', '%' . request('search') . '%');
        })->get();

        return view('penjualan.create', compact('sale', 'products'));
    }
}