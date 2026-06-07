<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $fillable = [
        'tanggal', 'pembeli', 'jenis_pembeli', 'jenis_telur',
        'jumlah', 'harga_perkilo', 'total',
        'jumlah_b', 'harga_perkilo_b', 'total_b',
        'keterangan', 'bukti_foto',
        'status_pembayaran', 'dibayar', 'kekurangan',
        'is_po', 'tanggal_ambil', 'status_po'
    ];
}
