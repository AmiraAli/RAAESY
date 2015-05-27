<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTicketsIdToTicketsStatues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ticket_statuses', function($table)
		    {
		        $table->integer('ticket_id')->unsigned();
		        $table->foreign('ticket_id')->references('id')->on('tickets');
		    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ticket_statuses', function($table)
		    {
		        $table->dropForeign('ticket_statuses_ticket_id_foreign');
				$table->dropColumn('ticket_id');
		    });
	}

}
