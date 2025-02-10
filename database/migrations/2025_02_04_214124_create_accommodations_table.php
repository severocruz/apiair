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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('accommodation_types');
            $table->foreignId('describe_id')->nullable()->constrained('describes');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('guest_capacity')->nullable();
            $table->integer('number_rooms')->nullable();
            $table->integer('number_bathrooms')->nullable();
            $table->integer('number_beds')->nullable();
            $table->decimal('price_night', 8, 2)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');

    }
};
