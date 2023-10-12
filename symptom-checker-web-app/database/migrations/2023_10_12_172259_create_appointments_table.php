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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time', $precision = 0);
            $table->time('end_time', $precision = 0);
            $table->foreignId('healthcare_provider_id')->constrained('healthcare_providers')->cascadeOnDelete();
            $table->foreignId('prediction_id')->constrained('predictions')->cascadeOnDelete();
            $table->text('notes');
            $table->string('status', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
