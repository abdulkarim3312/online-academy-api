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
     * Topic three -> page two (including next four)
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_three_content_twos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('overview_content_id')->nullable();
            $table->string('term_one_title')->nullable();
            $table->text('term_one_content')->nullable();
            $table->string('term_one_topic')->nullable();
            $table->text('term_one_topic_desc')->nullable();
            $table->string('term_one_image')->nullable();
            $table->string('term_two_title')->nullable();
            $table->text('term_two_content')->nullable();
            $table->string('term_two_topic')->nullable();
            $table->text('term_two_topic_desc')->nullable();
            $table->string('term_two_image')->nullable();
            $table->string('term_three_title')->nullable();
            $table->text('term_three_content')->nullable();
            $table->string('term_three_topic')->nullable();
            $table->text('term_three_topic_desc')->nullable();
            $table->string('term_three_image')->nullable();
            $table->string('term_four_title')->nullable();
            $table->text('term_four_content')->nullable();
            $table->string('term_four_topic')->nullable();
            $table->text('term_four_topic_desc')->nullable();
            $table->string('term_four_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_three_content_twos');
    }
};
