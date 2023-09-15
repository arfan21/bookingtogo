<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// CREATE TABLE IF NOT EXIST nationality (
//     national_id serial not null primary key,
//     national_name varchar(50) not null,
//     national_code varchar(2) not null,
// );


class CreateNationality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nationality', function (Blueprint $table) {
            $table->unsignedInteger('national_id')->nullable(false)->autoIncrement();
            $table->timestamps();
            $table->string('national_name', 50)->nullable(false);
            $table->string('national_code', 2)->nullable(false);
            $table->unique('national_name')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nationality');
    }
}
