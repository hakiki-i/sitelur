<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    use HasFactory;

    protected $table = 'kandang';
    // protected $primaryKey = 'id'; // default sudah id

    protected $fillable = [
        'nama_kandang',
        'jumlah_ayam',
        'keterangan'
    ];

    public function ayam()
    {
        return $this->hasMany(\App\Models\Ayam::class, 'kandang_id');
    }
}
