<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('author', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('author_name', 100);
			$table->string('author_surname', 100);
			$table->text('bio');
			$table->string('contact', 100);
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
		Schema::drop('author');
	}

}
