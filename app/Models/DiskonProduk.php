<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskonProduk extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_diskon_produk';

    public function produk(){
        return $this->hasMany(Produk::class, 'id_diskon_produk');
    }
}
