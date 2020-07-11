<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('Ownership')->nullable();
            $table->string('Account_Name')->nullable();
            $table->string('Account_Type')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Website')->nullable();
            $table->string('Industry')->nullable();
            $table->integer('Employees')->nullable();
            $table->text('Description')->nullable();
            $table->integer('Annual_Revenue')->nullable();
            $table->string('Billing_Country')->nullable();
            $table->string('Billing_Street')->nullable();
            $table->string('Billing_Code')->nullable();
            $table->string('Billing_City')->nullable();
            $table->string('Billing_State')->nullable();
            $table->string('exid')->default('0');
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
        Schema::dropIfExists('accounts');
    }
}
