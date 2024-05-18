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
        Schema::table('tournament_pairings', function (Blueprint $table) {
            $table->integer('table')->nullable()->after('round');
            $table->string('match')->nullable()->after('table');
            $table->text('player_2')->nullable('true')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_pairings', function (Blueprint $table) {
            $table->dropColumn('table');
            $table->dropColumn('match');
            $table->text('player_2')->nullable('false')->change();
        });
    }
};
