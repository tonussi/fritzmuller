<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('member', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->index('member_project_id_idx');
			$table->string('member_name', 300);
			$table->text('member_description');
			$table->string('grad', 200);
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
		Schema::drop('member');
	}

}
