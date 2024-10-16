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
        Schema::create('aset', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('nib_aset')->nullable();
            $table->string('nama_aset')->nullable();
            $table->bigInteger('id_kategori')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->string('img')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->bigInteger('id_unit')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('jml_mohon')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
