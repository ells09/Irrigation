<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuredTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('measured', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('humidity')->unsigned();
      $table->integer('temperature')->unsigned();
      $table->integer('hygrometer')->unsigned();
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
		Schema::drop('measured');
	}

}
