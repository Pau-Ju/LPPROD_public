<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostingTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'posting';

    /**
     * Run the migrations.
     * @table posting
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_Post_Keyword');
            $table->integer('id_Post_Serie');
            $table->integer('nb')->nullable()->default(null);
            $table->float('term_Frequency')->nullable()->default(null);

            $table->index(["id_Post_Serie"], 'FK_posting_serie');


            $table->foreign('id_Post_Keyword', 'posting_id_Post_Keyword')
                ->references('id_Word')->on('keywords')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_Post_Serie', 'FK_posting_serie')
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
