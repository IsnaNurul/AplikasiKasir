<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBeli extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'pembelian_id';

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'pembelian_id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_kode');
    }
}
