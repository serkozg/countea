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
        Schema::create('transaksi_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_pengeluaran')->nullable();
            $table->unsignedBigInteger('mtransaksi_id')->nullable();
            $table->foreign('mtransaksi_id')
            ->references('id')->on('master_transaksi')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('no_bukti')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('transaksi_pengeluaran');
        Schema::enableForeignKeyConstraints();
    }
};
