<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxonomyGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxonomy_group', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('kingdom_id')->index('taxonomy_group_kingdom_id_idx');
			$table->integer('phylum_id')->index('taxonomy_group_phylum_id_idx');
			$table->integer('class_id')->index('taxonomy_group_class_id_idx');
			$table->integer('order_id')->index('taxonomy_group_order_id_idx');
			$table->integer('family_id')->index('taxonomy_group_family_id_idx');
			$table->integer('genus_id')->index('taxonomy_group_genus_id_idx');
			$table->integer('specie_id')->index('taxonomy_group_specie_id_idx');
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
		Schema::drop('taxonomy_group');
	}

}
