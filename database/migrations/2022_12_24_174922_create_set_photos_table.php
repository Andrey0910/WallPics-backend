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
        Schema::create('set_photos', function (Blueprint $table) {
            $table->id();
            $table->string('origin_photo');
            $table->string('md5_origin_photo');
            $table->string('md5_medium_photo');
            $table->string('md5_little_photo');
            $table->integer('like')->default(0);
            $table->bigInteger('photos_id');
            $table->bigInteger('clients_id');
            $table->bigInteger('categories_id');
            $table->foreign('photos_id')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('clients_id')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('set_photos');
    }
};
