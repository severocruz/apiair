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
        //
        Schema::table('reserves', function (Blueprint $table) {
            $table->dateTime('checkin_date')->nullable();
            $table->dateTime('checkout_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('reserves', function (Blueprint $table) {
            $table->dropColumn('checkin_date');
            $table->dropColumn('checkout_date');
        });
    }
};
