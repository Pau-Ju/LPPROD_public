<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'favorites';

    /**
     * Run the migrations.
     * @table favorites
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_Favorite_User');
            $table->integer('id_Favorite_Serie');

            $table->index(["id_Favorite_Serie"], 'id_Favorite_Serie');

            $table->index(["id_Favorite_User", "id_Favorite_Serie"], 'id_Favorite_User');


            $table->foreign('id_Favorite_Serie', 'id_Favorite_Serie')
                ->references('id_Serie')->on('series')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_Favorite_User', 'favorites_id_Favorite_User')
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
