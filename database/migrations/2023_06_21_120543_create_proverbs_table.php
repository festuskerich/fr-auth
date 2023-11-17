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
        Schema::create('proverbs', function (Blueprint $table) {
            $table->id();
            $table->text("local_proverb");
            $table->text('meaning')->nullable();
            $table->text('eng_transalion')->nullable();
            $table->boolean("is_active")->nullable();
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
        Schema::dropIfExists('proverbs');
    }
};
