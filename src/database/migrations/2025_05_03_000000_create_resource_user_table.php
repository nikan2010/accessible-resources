<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resource_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('resource_id');
            $table->string('resource_type');
            $table->timestamps();

            $table->index(['user_id', 'resource_type', 'resource_id'], 'user_resource_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_user');
    }
};
