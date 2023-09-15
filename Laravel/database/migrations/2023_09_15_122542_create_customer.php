<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// CREATE TABLE IF NOT EXIST customer (
//     cst_id serial not null primary key,
//     national_id int not null,
//     cst_name varchar(50) not null,
//     cst_dob date not null,
//     cst_phoneNum varchar(20) not null,
//     cst_email varchar(50) not null,
// );

// ALTER TABLE customer ADD CONSTRAINT nationality_customer_to_fkey FOREIGN KEY (national_id) REFERENCES nationality (id);

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->unsignedInteger('cst_id')->nullable(false)->autoIncrement();
            $table->timestamps();
            $table->foreignId('national_id')->nullable(false)->references("national_id")->on("nationality");
            $table->string('cst_name', 50)->nullable(false);
            $table->date('cst_dob')->nullable(false);
            $table->string('cst_phoneNum', 20)->nullable(false);
            $table->string('cst_email', 50)->nullable(false);
            $table->unique('cst_email')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
