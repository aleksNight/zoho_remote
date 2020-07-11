<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('subject');
            $table->dateTime('created');
            $table->dateTime('closed')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->string('module')->nullable();
            $table->string('contact_exid')->nullable(); //lead or contact
            $table->string('record_exid')->nullable(); // all other module
            $table->string('exid')->default('0');
            $table->string('owner_exid')->default('0');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('record_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('record_id')->references('id')->on('deals');
            $table->foreign('contact_id')->references('id')->on('contacts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
