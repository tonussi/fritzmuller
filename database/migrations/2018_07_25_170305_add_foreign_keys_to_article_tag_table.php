<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToArticleTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article_tag', function(Blueprint $table)
		{
			$table->foreign('tag_id', 'fk_article_tag__tag_id')->references('id')->on('tag')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('article_id', 'fk_article_tag__article_id')->references('id')->on('articles')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article_tag', function(Blueprint $table)
		{
			$table->dropForeign('fk_article_tag__tag_id');
			$table->dropForeign('fk_article_tag__article_id');
		});
	}

}
