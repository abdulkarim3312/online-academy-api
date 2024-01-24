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
     * Topic one -> page five
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_one_content_fives', function (Blueprint $table) {
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
            $table->text('point_five_content')->nullable();
            $table->text('point_six_content')->nullable();
            $table->text('point_seven_content')->nullable();
            $table->text('point_eight_content')->nullable();
            $table->text('point_nine_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_one_content_fives');
    }
};
