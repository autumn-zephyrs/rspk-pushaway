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
            $table->text('player_name');
            $table->text('country')->nullable();
            $table->integer('placement');
            $table->integer('drop')->nullable();
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
