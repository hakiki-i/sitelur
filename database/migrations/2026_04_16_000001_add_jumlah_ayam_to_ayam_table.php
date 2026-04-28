<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ayam', function (Blueprint $table) {
            $table->integer('jumlah_ayam')->after('kandang_id');
        });
    }

    public function down(): void
    {
        Schema::table('ayam', function (Blueprint $table) {
            $table->dropColumn('jumlah_ayam');
        });
    }
};
