<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';
    protected $guarded = '';
    protected $primaryKey = 'kode_produk';
    protected $keyType = 'string';

    public function kategori_produk(){
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    public function diskon_produk(){
        return $this->belongsTo(DiskonProduk::class, 'diskon_produk_id');
    }

    public function detail_beli(){
        return $this->hasMany(DetailBeli::class, 'kode_produk');
    }
}
