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
        Schema::create('config', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('app_name')->nullable();
            $table->string('pemda')->nullable();
            $table->string('logo')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('tentang', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
