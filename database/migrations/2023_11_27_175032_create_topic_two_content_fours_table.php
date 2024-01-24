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
     * Topic two -> page four
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_two_content_fours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('overview_content_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('footer_title')->nullable();
            $table->string('term_one_title')->nullable();
            $table->string('term_one_sub_title')->nullable();
            $table->text('term_one_content_one')->nullable();
            $table->text('term_one_content_two')->nullable();
            $table->string('term_two_title')->nullable();
            $table->string('term_two_sub_title')->nullable();
            $table->text('term_two_content')->nullable();
            $table->string('term_three_title')->nullable();
            $table->string('term_three_sub_title')->nullable();
            $table->text('term_three_content')->nullable();
            $table->string('term_four_title')->nullable();
            $table->string('term_four_sub_title')->nullable();
            $table->text('term_four_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_two_content_fours');
    }
};
