<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     * Topic three -> page one
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_three_content_ones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('overview_content_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_three_content_ones');
    }
};
