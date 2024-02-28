<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_penjualan';
    
    public function pengguna() {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    } 

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    } 

    public function pengiriman() {
        return $this->hasMany(Pengiriman::class, 'id_penjualan');
    } 

    public function detail_jual() {
        return $this->hasMany(DetailJual::class, 'id_penjualan');
    }
}


