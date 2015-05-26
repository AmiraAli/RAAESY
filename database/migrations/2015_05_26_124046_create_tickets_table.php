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
			$table->dateTime('createddate');
			$table->dateTime('deadline');
		
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');

			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('tech_id')->unsigned();
			$table->foreign('tech_id')->references('id')->on('users');

			$table->integer('admin_id')->unsigned();
			$table->foreign('admin_id')->references('id')->on('users');	

			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('ticket_statuses');	
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
