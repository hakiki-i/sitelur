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
        $bpk = \App\Models\Pengaturan::butirPerKg();
        $total = self::whereIn('status', ['final', 'approved'])->sum('telur_layak');
        
        // Penjualan nyata yang memotong fisik telur
        $jual = \App\Models\Penjualan::where(function($q) {
            $q->where('is_po', 0)->orWhere('status_po', 'diambil');
        })->whereIn('jenis_telur', ['layak', 'keduanya'])->sum('jumlah') * $bpk;

        // PO pending yang sudah terkunci (H-2 dari tanggal ambil)
        $po_terkunci = \App\Models\Penjualan::where('is_po', 1)
            ->where('status_po', 'pending')
            ->whereDate('tanggal_ambil', '<=', now()->addDays(2)->toDateString())
            ->whereIn('jenis_telur', ['layak', 'keduanya'])
            ->sum('jumlah') * $bpk;

        return $total - $jual - $po_terkunci;
    }

    /**
     * Mendapatkan stok telur tidak layak (butir) yang valid (produksi final/approved dikurangi penjualan).
     */
    public static function stokTidakLayak()
    {
        $bpk = \App\Models\Pengaturan::butirPerKg();
        $total = self::whereIn('status', ['final', 'approved'])->sum('telur_tidak_layak');
        
        // Penjualan nyata yang memotong fisik telur
        $jual = (\App\Models\Penjualan::where(function($q) {
                $q->where('is_po', 0)->orWhere('status_po', 'diambil');
            })->where('jenis_telur', 'tidak_layak')->sum('jumlah') 
            + \App\Models\Penjualan::where(function($q) {
                $q->where('is_po', 0)->orWhere('status_po', 'diambil');
            })->where('jenis_telur', 'keduanya')->sum('jumlah_b')) * $bpk;

        // PO pending yang sudah terkunci (H-2 dari tanggal ambil)
        $po_terkunci = (\App\Models\Penjualan::where('is_po', 1)
            ->where('status_po', 'pending')
            ->whereDate('tanggal_ambil', '<=', now()->addDays(2)->toDateString())
            ->where('jenis_telur', 'tidak_layak')->sum('jumlah')
            + \App\Models\Penjualan::where('is_po', 1)
            ->where('status_po', 'pending')
            ->whereDate('tanggal_ambil', '<=', now()->addDays(2)->toDateString())
            ->where('jenis_telur', 'keduanya')->sum('jumlah_b')) * $bpk;

        return $total - $jual - $po_terkunci;
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
        $bpk = \App\Models\Pengaturan::butirPerKg();
        return floor((self::stokLayak() + self::stokTidakLayak()) / $bpk);
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'id_kandang');
    }
}
