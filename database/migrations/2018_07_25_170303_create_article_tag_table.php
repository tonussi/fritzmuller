<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_tag', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('tag_id')->index('article_tag_tag_id_idx');
			$table->integer('article_id')->index('article_tag_article_id_idx');
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
		Schema::drop('article_tag');
	}

}
