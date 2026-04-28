<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaTelur extends Model
{
    use HasFactory;
    protected $table = 'harga_telur';
    protected $fillable = ['harga_layak', 'harga_tidak_layak', 'tanggal'];
}
