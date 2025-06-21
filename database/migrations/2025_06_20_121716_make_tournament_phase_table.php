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
        Schema::create('tournament_phase', function (Blueprint $table) {
            $table->id();
            $table->text('tournament_limitless_id');
            $table->integer('phase');
            $table->text('type');
            $table->integer('rounds');
            $table->text('mode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_phase');
    }
};
