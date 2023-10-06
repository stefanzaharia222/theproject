<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entity', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag')->unique()->nullable();
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity');
    }
};
