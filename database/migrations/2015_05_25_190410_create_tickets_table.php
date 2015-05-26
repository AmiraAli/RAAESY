<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('description');
			$table->string('file');
			$table->enum('priority', ['low', 'high','critical'])->default('low');


			$table->dateTime('date');
			$table->dateTime('deadline');
		

			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');

			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->integer('usermake_id')->unsigned();
			$table->foreign('usermake_id')->references('id')->on('users');	

			$table->integer('assigneduser_id')->unsigned();
			$table->foreign('assigneduser_id')->references('id')->on('users');	


			$table->integer('state_id')->unsigned();
			$table->foreign('state_id')->references('id')->on('states');	

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
		Schema::drop('tickets');
	}

}
