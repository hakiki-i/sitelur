<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksi';
    protected $fillable = [
        'tanggal', 'id_kandang', 'jumlah', 'telur_layak', 'telur_tidak_layak', 'status'
    ];

    /**
     * Mendapatkan stok telur layak (butir) yang valid (produksi final/approved dikurangi penjualan).
     */
    public static function stokLayak()
    {
        $total = self::whereIn('status', ['final', 'approved'])->sum('telur_layak');
        $jual = \App\Models\Penjualan::where('jenis_telur', 'layak')->sum('jumlah') * 15;
        return $total - $jual;
    }

    /**
     * Mendapatkan stok telur tidak layak (butir) yang valid (produksi final/approved dikurangi penjualan).
     */
    public static function stokTidakLayak()
    {
        $total = self::whereIn('status', ['final', 'approved'])->sum('telur_tidak_layak');
        $jual = \App\Models\Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah') * 15;
        return $total - $jual;
    }

    /**
     * Mendapatkan total stok telur (butir) valid.
     */
    public static function stokTotalButir()
    {
        return self::stokLayak() + self::stokTidakLayak();
    }

    /**
     * Mendapatkan total stok telur (kg) valid.
     */
    public static function stokTotalKg()
    {
        return floor((self::stokLayak() + self::stokTidakLayak()) / 15);
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'id_kandang');
    }
}
