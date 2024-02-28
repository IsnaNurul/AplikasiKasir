<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Authenticatable
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_pengguna';

    public function administrator(){
        return $this->hasMany(Administrator::class, 'id_pengguna');
    }

    public function petugas(){
        return $this->hasMany(Petugas::class, 'id_pengguna');
    }

    public function pelanggan(){
        return $this->hasMany(Pelanggan::class, 'id_pengguna');
    }

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'id_pengguna');
    }

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'id_penjualan');
    }
}
