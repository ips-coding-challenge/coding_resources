<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->mediumText('description')->nullable();
            $table->string('youtube_id')->unique();
            $table->unsignedInteger('langue_id')->nullable();
            $table->boolean('is_valid')->default(0);
            $table->string('channel_name')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('tutos');
    }
}
