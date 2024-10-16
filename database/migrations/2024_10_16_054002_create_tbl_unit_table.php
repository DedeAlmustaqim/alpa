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
        Schema::create('tbl_unit', function (Blueprint $table) {
            $table->integer('id', true)->index('id');
            $table->string('nm_unit')->nullable()->index('idx_tbl_unit_nm_unit');
            $table->string('pimpinan')->nullable()->index('idx_tbl_unit_pimpinan');
            $table->string('nip_pimpinan')->nullable();
            $table->string('gol')->nullable()->index('gol');
            $table->string('jabatan')->nullable()->index('idx_tbl_unit_jabatan');
            $table->string('lat', 50)->nullable()->index('idx_tbl_unit_lat');
            $table->string('long', 50)->nullable()->index('idx_tbl_unit_long');
            $table->integer('radius')->nullable()->index('idx_tbl_unit_radius');
            $table->timestamp('created_at')->nullable()->useCurrent()->index('created_at');
            $table->timestamp('updated_at')->nullable()->useCurrent()->index('idx_tbl_unit_updated_at');
            $table->string('qr_in', 10)->nullable()->index('idx_tbl_unit_qr_in');
            $table->string('qr_out', 10)->nullable()->index('idx_tbl_unit_qr_out');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('hari_kerja', ['5', '6'])->nullable()->default('5');
            $table->string('kasubbag')->nullable();
            $table->string('nip_kasubbag')->nullable();

            $table->index(['created_at'], 'idx_tbl_unit_created_at');
            $table->index(['gol'], 'idx_tbl_unit_gol');
            $table->index(['id'], 'idx_tbl_unit_id');
            $table->index(['jabatan'], 'jabatan');
            $table->index(['lat'], 'lat');
            $table->index(['long'], 'long');
            $table->index(['nm_unit'], 'nm_unit');
            $table->index(['pimpinan'], 'pimpinan');
            $table->primary(['id']);
            $table->index(['qr_in'], 'qr_in');
            $table->index(['qr_out'], 'qr_out');
            $table->index(['radius'], 'radius');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_unit');
    }
};
