<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoshop', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('mobile_phone');
            $table->string('andress');
            $table->string('email');  
            $table->string('header_sale');
            $table->string('coppyright');
            $table->string('link_fb')->nullable();
            $table->string('link_gg_plus')->nullable();
            $table->string('link_pinterest')->nullable();
            $table->string('link_instagram')->nullable();
         
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
        Schema::dropIfExists('infoshop');
    }
}