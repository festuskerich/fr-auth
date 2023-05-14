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
        Schema::create('subtribes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->string("residence")->nullable();
            $table->unsignedBigInteger('language_id');
            $table->timestamps();
            $table->foreign('language_id')->references('id')->on('native_languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtribes');
    }
};
