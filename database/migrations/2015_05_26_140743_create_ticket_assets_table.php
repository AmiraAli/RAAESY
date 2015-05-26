<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_assets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('asset_id')->unsigned();
			$table->foreign('asset_id')->references('id')->on('assets');
			$table->integer('ticket_id')->unsigned();
			$table->foreign('ticket_id')->references('id')->on('tickets');
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
		Schema::drop('ticket_assets');
	}

}
