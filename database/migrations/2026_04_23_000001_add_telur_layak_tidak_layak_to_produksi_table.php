<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produksi', function (Blueprint $table) {
            $table->integer('telur_layak')->nullable()->after('jumlah');
            $table->integer('telur_tidak_layak')->nullable()->after('telur_layak');
        });
    }

    public function down(): void
    {
        Schema::table('produksi', function (Blueprint $table) {
            $table->dropColumn(['telur_layak', 'telur_tidak_layak']);
        });
    }
};
