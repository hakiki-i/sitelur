<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('harga_telur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('harga_layak');
            $table->integer('harga_tidak_layak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harga_telur');
    }
};
