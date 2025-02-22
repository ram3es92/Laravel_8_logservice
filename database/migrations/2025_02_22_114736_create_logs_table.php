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
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('time');
            $table->integer('duration');
            $table->string('ip',100)->nullable();
            $table->string('url',255)->nullable();
            $table->string('method',10)->nullable();
            $table->string('input')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
