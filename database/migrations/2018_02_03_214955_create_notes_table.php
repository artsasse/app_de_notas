<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('notes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('noteTitle')->default('Título');
          $table->mediumText('noteContent')->nullable();
          /*
          $table->dateTime('reminder'); #LEMBRETE
          $table->integer('user_id')->unsigned()->nullable(); #ESTABELECENDO FOREIGN KEY COM OS USUARIOS
          $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
          $table->text('noteAdress');
          */

          /*$table->integer('tag_id')->unsigned()->nullable(); #ESTABELECENDO FOREIGN KEY COM AS TAGS
          $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');*/


          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
