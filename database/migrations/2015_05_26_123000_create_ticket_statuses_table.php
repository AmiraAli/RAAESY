<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_statuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->enum('value', ['close', 'open']);
			$table->integer('ticket_id')->unsigned();
		    $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
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
		Schema::drop('ticket_statuses');
	}

}
