<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('id_kandang');
            $table->integer('jumlah');
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->foreign('id_kandang')->references('id')->on('kandang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
