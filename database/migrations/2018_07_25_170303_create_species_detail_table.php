<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpeciesDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('species_detail', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('taxonomy_group_id')->index('species_detail_taxonomy_group_id_idx');
			$table->text('species_description');
			$table->string('figure_path', 500);
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
		Schema::drop('species_detail');
	}

}
