<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_pelanggan';

    public function pengguna(){
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}
