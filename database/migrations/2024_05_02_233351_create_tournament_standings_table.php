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
        Schema::create('tournament_standings', function (Blueprint $table) {
            $table->id();
            $table->text('tournament_limitless_id');
            $table->text('player_username');
            $table->integer('placement');
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->integer('ties')->nullable();
            $table->text('identifier')->nullable();
            $table->integer('drop')->nullable();
            $table->date('date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_standings');
    }
};
