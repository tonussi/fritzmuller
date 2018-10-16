<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPopularNameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('popular_name', function(Blueprint $table)
		{
			$table->foreign('species_detail_id', 'fk_popular_name__species_detail_id')->references('id')->on('species_detail')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('popular_name', function(Blueprint $table)
		{
			$table->dropForeign('fk_popular_name__species_detail_id');
		});
	}

}
