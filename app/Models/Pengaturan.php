<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

/**
 * Pengaturan berbasis file JSON (storage/app/pengaturan.json).
 * Tidak memerlukan tabel database.
 */
class Pengaturan
{
    protected static string $disk = 'local';
    protected static string $file = 'pengaturan.json';

    /**
     * Baca semua pengaturan dari file JSON.
     */
    public static function all(): array
    {
        if (!Storage::disk(static::$disk)->exists(static::$file)) {
            return static::defaults();
        }

        $data = json_decode(Storage::disk(static::$disk)->get(static::$file), true);
        return array_merge(static::defaults(), $data ?? []);
    }

    /**
     * Ambil nilai pengaturan berdasarkan key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::all();
        return $all[$key] ?? $default;
    }

    /**
     * Simpan/update nilai pengaturan.
     */
    public static function set(string $key, mixed $value): void
    {
        $all = static::all();
        $all[$key] = $value;
        Storage::disk(static::$disk)->put(static::$file, json_encode($all, JSON_PRETTY_PRINT));
    }

    /**
     * Shortcut: ambil nilai butir per kg (default 15).
     */
    public static function butirPerKg(): int
    {
        return (int) static::get('butir_per_kg', 15);
    }

    /**
     * Nilai default pengaturan.
     */
    protected static function defaults(): array
    {
        return [
            'butir_per_kg' => 15,
        ];
    }
}
