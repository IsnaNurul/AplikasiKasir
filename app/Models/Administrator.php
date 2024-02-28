<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;
    protected $guarded = '';
    protected $primaryKey = 'id_administrator';

    public function pengguna(){
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
