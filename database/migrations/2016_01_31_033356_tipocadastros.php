<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Tipocadastros
 *
 * @author  The scaffold-interface created at 2016-01-31 03:33:56pm
 * @link  https://github.com/amranidev/scaffold-interfac
 */
class Tipocadastros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('tipocadastros',function (Blueprint $table){

        $table->increments('id');
        
        $table->string('descricao');
        
        /**
         * Foreignkeys section
         */
        
        // type your addition here

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('tipocadastros');
     }
}
