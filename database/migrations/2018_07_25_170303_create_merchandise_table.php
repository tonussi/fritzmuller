<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchandiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchandise', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('figure_path', 500);
			$table->string('title', 100);
			$table->string('activity_description', 300);
			$table->string('target_url', 300);
			$table->boolean('active')->default(1);
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
		Schema::drop('merchandise');
	}

}
