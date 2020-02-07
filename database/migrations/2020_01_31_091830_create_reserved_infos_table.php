<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservedInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20);
            $table->date('reserved_date');
            $table->integer('reserved_time');
            $table->integer('price');
            $table->string('mail_address', 50);
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
        Schema::dropIfExists('reserved_infos');
    }
}
