<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    use HasFactory;
    
    protected $table = 'agens';
    protected $fillable = ['nama_agen', 'nomor_hp', 'alamat'];
}
