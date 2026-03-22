<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('race_contestants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('race_id');
            $table->string('contestant_id');
            $table->timestamps();

            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
            $table->foreign('contestant_id')->references('id')->on('contestants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('race_contestants');
    }
};
