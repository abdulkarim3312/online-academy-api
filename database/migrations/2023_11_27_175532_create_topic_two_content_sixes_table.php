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
     * Topic two -> page six
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_two_content_sixes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('overview_content_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('footer_title')->nullable();
            $table->string('image')->nullable();
            $table->text('point_one_content')->nullable();
            $table->text('point_two_content')->nullable();
            $table->text('point_three_content')->nullable();
            $table->text('point_four_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_two_content_sixes');
    }
};
