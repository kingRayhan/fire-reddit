<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('body')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->timestamps();

            $table->string('thumbnail')->nullable();
            $table->boolean('is_link')->default(false);
            $table->string('link')->nullable();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');


            $table->foreign('parent_id')
                ->on('threads')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
