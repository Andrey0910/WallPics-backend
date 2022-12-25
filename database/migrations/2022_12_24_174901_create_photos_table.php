<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('origin_photo');
            $table->string('md5_origin_photo');
            $table->string('md5_medium_photo');
            $table->string('md5_little_photo');
            $table->integer('like')->default(0);
            $table->tinyInteger('isActive')->default(0);
            $table->tinyInteger('isDelete')->default(0);
            $table->foreignId('clients_id');
            $table->foreignId('categories_id');
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
        Schema::dropIfExists('photos');
    }
};
