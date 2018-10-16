<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToArticleSpecieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article_specie', function(Blueprint $table)
		{
			$table->foreign('species_id', 'fk_article_specie__species_id')->references('id')->on('species_detail')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('article_id', 'fk_article_specie__article_id')->references('id')->on('articles')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article_specie', function(Blueprint $table)
		{
			$table->dropForeign('fk_article_specie__species_id');
			$table->dropForeign('fk_article_specie__article_id');
		});
	}

}
