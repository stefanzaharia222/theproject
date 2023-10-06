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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('tooltip')->nullable();
            $table->string('language')->nullable();
            $table->string('reason')->nullable();
            $table->string('tag')->unique()->nullable();
            $table->text('tickets')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
