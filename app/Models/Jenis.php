<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'jenis_id');
    }
}