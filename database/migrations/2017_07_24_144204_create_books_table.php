<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('link');
            $table->string('cover')->nullable();
            $table->unsignedInteger('langue_id')->nullable();
            $table->boolean('is_valid')->default(0);
            $table->timestamps();

            $table->foreign('langue_id')->references('id')->on('langues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
