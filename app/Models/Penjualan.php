<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $fillable = [
        'tanggal', 'pembeli', 'jenis_pembeli', 'jenis_telur', 'jumlah', 'harga_perkilo', 'total', 'keterangan', 'bukti_foto'
    ];
}
