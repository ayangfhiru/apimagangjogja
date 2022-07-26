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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('namaLengkap');
            $table->string('nik');
            $table->string('jenisKelamin', 12);
            $table->string('nomorWhatsapp', 15);
            $table->string('asalSekolah');
            $table->string('programStudi');
            $table->string('kotaAsal');
            $table->string('alasanMagang');
            $table->string('jenisMagang', 20);
            $table->string('sistemMagang', 5);
            $table->string('statusAnda', 20);
            $table->string('bukuInggris', 20);
            $table->string('whatsappDosen', 15);
            $table->string('programMagang', 50);
            $table->string('jamKerja', 15);
            $table->string('yangDikuasai')->nullable();
            $table->string('laptop', 10);
            $table->string('memilikiAlat');
            $table->string('mulaiMagang', 30);
            $table->string('infoMagang', 20);
            $table->string('motor', 10);
            $table->double('tglGabung');
            $table->string('curriculumvitae')->nullable();
            $table->string('portofolio')->nullable();

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
        Schema::dropIfExists('detail_users');
    }
};
