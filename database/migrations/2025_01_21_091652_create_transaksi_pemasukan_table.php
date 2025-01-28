<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pemasukan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pemasukan')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
            ->references('id')->on('barang')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->date('tanggal')->useCurrent();
            $table->integer('jumlah')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transaksi_pemasukan');
        Schema::enableForeignKeyConstraints();
    }
};
