<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'comments';

    /**
     * Run the migrations.
     * @table comments
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_Comment');
            $table->unsignedInteger('id_Comment_User');
            $table->integer('id_Comment_Serie');
            $table->string('comment_type', 50);
            $table->string('comment');

            $table->index(["id_Comment_Serie"], 'id_Comment_Serie');

            $table->index(["id_Comment_User"], 'id_Comment_User');


            $table->foreign('id_Comment_User', 'id_Comment_User')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_Comment_Serie', 'id_Comment_Serie')
                ->references('id_Serie')->on('series')
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
