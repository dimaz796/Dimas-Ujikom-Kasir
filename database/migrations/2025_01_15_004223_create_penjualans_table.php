<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->date('tanggal_penjualan');
            $table->decimal('total_harga', 12, 2);
            $table->string('pelanggan_id', 10)->nullable();
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggan')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->decimal('nominal_pembayaran', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
