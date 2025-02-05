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
        Schema::create('accommodation_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->longText('photo_url');
            $table->boolean('mainPhoto')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_photos');
    }
};
