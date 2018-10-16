<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleAuthorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_author', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('author_id')->index('article_author_author_id_idx');
			$table->integer('article_id')->index('article_author_article_id_idx');
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
		Schema::drop('article_author');
	}

}
