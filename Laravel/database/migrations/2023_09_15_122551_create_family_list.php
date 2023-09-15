<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// CREATE TABLE IF NOT EXIST family_list (
//     fl_id serial not null primary key,
//     cst_id int not null,
//     fl_relation varchar(20) not null,
//     fl_name varchar(50) not null,
//     fl_dob date not null,
// );

// ALTER TABLE family_list ADD CONSTRAINT customer_family_list_to_fkey FOREIGN KEY (cst_id) REFERENCES customer (id);

class CreateFamilyList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_list', function (Blueprint $table) {
            $table->unsignedInteger('fl_id')->nullable(false)->autoIncrement();
            $table->timestamps();
            $table->foreignId('cst_id')->nullable(false)->references("cst_id")->on("customer")->onDelete("cascade");
            $table->string('fl_relation', 20)->nullable(false);
            $table->string('fl_name', 50)->nullable(false);
            $table->date('fl_dob')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_list');
    }
}
