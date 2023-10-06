<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entity_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('entity_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('entity_id')->references('id')->on('entity')->onDelete('CASCADE');
            $table->unique(['user_id', 'entity_id'], 'unique_user_per_entity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_user');
    }
};
