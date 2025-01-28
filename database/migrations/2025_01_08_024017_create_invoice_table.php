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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
            ->references('id')->on('barang')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('total')->nullable();
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas')->nullable();
            $table->timestamp('jatuh_tempo')->nullable();
            $table->string('gambar_invoice')->nullable();
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
        Schema::dropIfExists('invoice');
        Schema::enableForeignKeyConstraints();
    }
};
