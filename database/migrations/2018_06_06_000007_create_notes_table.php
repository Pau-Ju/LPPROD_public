<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'notes';

    /**
     * Run the migrations.
     * @table notes
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_Notes_User');
            $table->integer('id_Notes_Serie');
            $table->integer('note');

            $table->index(["id_Notes_User", "id_Notes_Serie"], 'id_Notes_User');

            $table->index(["id_Notes_Serie"], 'id_Notes_Serie');


            $table->foreign('id_Notes_Serie', 'id_Notes_Serie')
                ->references('id_Serie')->on('series')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_Notes_User', 'notes_id_Notes_User')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
