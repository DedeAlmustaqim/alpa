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
        Schema::create('tbl_mohon', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_aset')->nullable();
            $table->longText('catatan')->nullable();
            $table->string('srt_mohon')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('status')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_akhir')->nullable();
            $table->date('tgl_mulai_accept')->nullable();
            $table->date('tgl_akhir_accept')->nullable();
            $table->time('jam_mulai_accept')->nullable();
            $table->time('jam_akhir_accept')->nullable();
            $table->integer('reschedule_mohon')->nullable()->default(0);
            $table->timestamp('date_agree')->nullable();
            $table->timestamp('date_reject')->nullable();
            $table->timestamp('date_verif')->nullable();
            $table->timestamp('date_finish')->nullable();
            $table->string('note_reject', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mohon');
    }
};
