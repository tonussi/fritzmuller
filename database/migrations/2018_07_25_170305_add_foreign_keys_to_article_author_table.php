<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToArticleAuthorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article_author', function(Blueprint $table)
		{
			$table->foreign('author_id', 'fk_article_author__author_id')->references('id')->on('author')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('article_id', 'fk_article_author__article_id')->references('id')->on('articles')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article_author', function(Blueprint $table)
		{
			$table->dropForeign('fk_article_author__author_id');
			$table->dropForeign('fk_article_author__article_id');
		});
	}

}
