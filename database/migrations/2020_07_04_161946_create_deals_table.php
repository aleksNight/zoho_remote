<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('Deal_Name')->unique();
            $table->string('Owner_exid')->nullable();
            $table->integer('Amount')->default(0);
            $table->string('Stage')->nullable();
            $table->string('Type')->nullable();
            $table->string('Lead_Source')->nullable();
            $table->integer('Probability')->nullable();
            $table->text('Description')->nullable();
            $table->string('Contact_exid')->nullable();
            $table->string('Account_exid')->nullable();
            $table->integer('Expected_Revenue')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('exid')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('deals');
    }
}
