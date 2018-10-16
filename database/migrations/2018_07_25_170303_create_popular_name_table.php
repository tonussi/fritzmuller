<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePopularNameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('popular_name', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('species_detail_id')->index('popular_name_species_detail_id_idx');
			$table->string('popular_name', 200);
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
		Schema::drop('popular_name');
	}

}
