<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleSpecieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_specie', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('species_id')->index('article_specie_species_id_idx');
			$table->integer('article_id')->index('article_specie_article_id_idx');
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
		Schema::drop('article_specie');
	}

}
