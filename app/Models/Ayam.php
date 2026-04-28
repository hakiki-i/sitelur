<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    use HasFactory;

    protected $table = 'ayam';
    protected $fillable = [
        'jumlah_ayam',
        'tanggal_masuk',
        'kandang_id',
        'keterangan',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }
}
