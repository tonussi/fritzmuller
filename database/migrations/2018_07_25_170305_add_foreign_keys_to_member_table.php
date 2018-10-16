<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('member', function(Blueprint $table)
		{
			$table->foreign('project_id', 'fk_member__project_id')->references('id')->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('member', function(Blueprint $table)
		{
			$table->dropForeign('fk_member__project_id');
		});
	}

}
