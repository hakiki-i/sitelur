<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ayam', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ayam');
            $table->date('tanggal_masuk');
            $table->unsignedBigInteger('kandang_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kandang_id')->references('id')->on('kandang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayam');
    }
};
