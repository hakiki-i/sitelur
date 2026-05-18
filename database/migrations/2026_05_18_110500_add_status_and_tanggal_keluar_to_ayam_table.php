<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ayam', function (Blueprint $table) {
            $table->string('status')->default('aktif')->after('jumlah_ayam');
            $table->date('tanggal_keluar')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('ayam', function (Blueprint $table) {
            $table->dropColumn(['status', 'tanggal_keluar']);
        });
    }
};
