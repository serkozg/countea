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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_pemasukan')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
            ->references('id')->on('barang')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamp('tanggal')->useCurrent();
            $table->string('file_path')->nullable();
            $table->integer('potong_stok')->nullable();
            $table->integer('jumlah')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('transaksi');
        Schema::enableForeignKeyConstraints();
    }
};
