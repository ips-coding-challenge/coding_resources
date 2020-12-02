<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutoPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuto_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tuto_id')->index();
            $table->string('youtube_id')->unique();
            $table->string('title')->nullable();
            $table->integer('part_number');
            $table->timestamps();

            $table->foreign('tuto_id')->references('id')->on('tutos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tuto_parts');
    }
}
