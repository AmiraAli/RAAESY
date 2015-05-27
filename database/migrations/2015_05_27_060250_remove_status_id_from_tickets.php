<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveStatusIdFromTickets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function($table)
		    {
		        $table->dropForeign('tickets_status_id_foreign');
				$table->dropColumn('status_id');
		    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		   Schema::table('tickets', function($table)
		    {
		        $table->integer('status_id')->unsigned();
		        $table->foreign('status_id')->references('id')->on('ticket_statuses');
		    });
	}

}
