<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSpeciesDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('species_detail', function(Blueprint $table)
		{
			$table->foreign('taxonomy_group_id', 'fk_species_detail__taxonomy_group_id')->references('id')->on('taxonomy_group')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('species_detail', function(Blueprint $table)
		{
			$table->dropForeign('fk_species_detail__taxonomy_group_id');
		});
	}

}
