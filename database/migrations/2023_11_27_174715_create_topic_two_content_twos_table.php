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
     * Topic two -> page one
     * 
     *
     */
    public function up(): void
    {
        Schema::create('topic_two_content_twos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('overview_content_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('note_description')->nullable();
            $table->string('footer_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_two_content_twos');
    }
};
