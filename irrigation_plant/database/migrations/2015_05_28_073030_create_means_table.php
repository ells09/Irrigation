<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mean', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('min')->unsigned();
            $table->integer('mean')->unsigned();
            $table->integer('max')->unsigned();
            $table->string('type', 25);
            $table->dateTime('time');
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
		Schema::drop('mean');
	}

}
