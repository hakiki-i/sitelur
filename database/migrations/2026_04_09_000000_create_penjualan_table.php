<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('penjualan', function (Blueprint $table) {
			$table->id();
			$table->date('tanggal');
			$table->string('pembeli');
			$table->string('jenis_pembeli')->nullable(); // agen/toko/dll
			$table->integer('jumlah'); // jumlah telur
			$table->integer('harga_perkilo');
			$table->integer('total');
			$table->text('keterangan')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('penjualan');
	}
};
