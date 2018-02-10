<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_tags', function (Blueprint $table) {
            $table->increments('id');
            //$table->timestamps();
            $table->softDeletes();
            $table->integer('note_id')->unsigned()->nullable();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('set null');
            $table->integer('tag_id')->unsigned()->nullable();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_tags');
    }
}
