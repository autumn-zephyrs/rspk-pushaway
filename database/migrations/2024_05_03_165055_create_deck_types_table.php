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
        Schema::create('deck_types', function (Blueprint $table) {
            $table->id();
            $table->text('identifier');
            $table->text('name');
            $table->text('icon_primary')->nullable();
            $table->text('icon_secondary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deck_types');
    }
};
