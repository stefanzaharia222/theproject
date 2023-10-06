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
        Schema::create('select_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_name');
            $table->string('option_kind');
            $table->string('tooltip');
            $table->string('placeholder');
            $table->string('description');
            $table->string('tag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('select_options');
    }
};
