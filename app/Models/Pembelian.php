<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $guarded = '';
    protected $primaryKey = 'id_pembelian';

    public function detail_beli(){
        return $this->belongsTo(DetailBeli::class, 'id_pembelian');
    }

    public function pengguna(){
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
