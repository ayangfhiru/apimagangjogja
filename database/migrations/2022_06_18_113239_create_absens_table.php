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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('lokasi')->nullable(false);
            $table->date('tanggal');
            $table->double('masuk');
            $table->double('istirahatKeluar')->nullable();
            $table->double('istirahatMasuk')->nullable();
            $table->double('izinKeluar')->nullable();
            $table->double('izinMasuk')->nullable();
            $table->double('pulang')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('absens');
    }
};
