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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();            
            $table->foreignId('accommodation_id')->constrained('accommodations')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_guests');
            $table->decimal('total_price', 10, 2);
            $table->decimal('cash_discount', 10, 2);
            $table->decimal('commission', 10, 2);
            $table->string('state')->default('Pendiente');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
