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
        Schema::create('health_condition_specialties', function (Blueprint $table) {
            $table->foreignId('health_condition_id')->constrained('health_conditions')->cascadeOnDelete();
            $table->foreignId('speciality_id')->constrained('specialties')->cascadeOnDelete();
            $table->primary(['health_condition_id', 'speciality_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_condition_specialties');
    }
};
