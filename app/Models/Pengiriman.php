<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_pengiriman';

    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}