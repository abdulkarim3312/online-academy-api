<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Important note: about status
     * approval -> approved
     * stop -> suspended
     * dormancy -> inactive
     * secession -> deleted
     * 
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('admin_id')->comment('Unique id for each user.');
            $table->string('name');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->comment('Unique email for each user.');
            $table->enum('situation', ['approval', 'stop', 'dormancy', 'secession'])->nullable();
            $table->enum('rating', ['system', 'top-level', 'teacher'])->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('admin id by whom the user is created.');
            $table->string('photo')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['admin_id', 'deleted_at']);
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
