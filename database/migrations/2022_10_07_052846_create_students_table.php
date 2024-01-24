<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Important note: here students will considered as employee
     * Important note: about status
     * approval -> approved
     * stop -> suspended
     * dormancy -> inactive
     * secession -> deleted
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->comment('Unique id for each user.');
            $table->unsignedInteger('user_id')->comment('parent id by whom the student is created.');
            $table->string('name');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->comment('Unique email for each user.');
            $table->string('otp')->nullable();
            $table->enum('situation', ['approval', 'stop', 'dormancy', 'secession'])->nullable();
            $table->longText('memo')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['student_id', 'deleted_at']);
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
        Schema::dropIfExists('students');
    }
};
