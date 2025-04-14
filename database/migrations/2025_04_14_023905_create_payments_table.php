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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserve_id')->constrained('reserves')->onDelete('cascade');
            $table->decimal('mount', 10, 2)->nullable();
            $table->string('method')->nullable();
            $table->string('reference')->nullable();
            $table->string('transaction_id')->nullable();
            $table->dateTime('transaction_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
