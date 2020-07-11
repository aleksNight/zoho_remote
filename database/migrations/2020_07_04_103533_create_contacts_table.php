<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('First_Name')->nullable();
            $table->string('Last_Name')->nullable();
            $table->string('Title')->nullable();
            $table->string('Email');
            $table->string('Mobile')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Twitter')->nullable();
            $table->string('Skype_ID')->nullable();
            $table->string('Mailing_Zip')->nullable();
            $table->string('Mailing_Country')->nullable();
            $table->string('Mailing_City')->nullable();
            $table->string('Mailing_Street')->nullable();
            $table->string('Department')->nullable();
            $table->string('Lead_Source')->nullable();
            $table->string('exid')->default('0');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
