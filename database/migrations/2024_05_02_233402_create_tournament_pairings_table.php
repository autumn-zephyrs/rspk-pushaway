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
        Schema::create('tournament_pairings', function (Blueprint $table) {
            $table->id();
            $table->text('tournament_limitless_id');
            $table->integer('round');
            $table->integer('phase');
            $table->text('player_1');
            $table->text('player_2');
            $table->text('winner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_pairings');
    }
};
