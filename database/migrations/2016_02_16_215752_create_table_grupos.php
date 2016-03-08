<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrupos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table)
        {

            $table->increments('id');

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nome', 45);
            $table->integer('empresas_id');
            $table->integer('empresas_clientes_cloud_id');
            $table->smallinteger('default');
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grupos');
    }
}
