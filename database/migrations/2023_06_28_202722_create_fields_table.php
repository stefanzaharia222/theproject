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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('class');
            $table->string('type');
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->string('tag')->unique()->nullable();
            $table->string('placeholder')->nullable();
            $table->string('tooltip')->nullable();
            $table->string('description')->nullable();
            $table->string('language')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
