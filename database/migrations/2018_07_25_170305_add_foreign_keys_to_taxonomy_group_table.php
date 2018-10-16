<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaxonomyGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taxonomy_group', function(Blueprint $table)
		{
			$table->foreign('kingdom_id', 'fk_taxonomy_group__kingdom_id')->references('id')->on('taxonomy_rank_kingdom')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('phylum_id', 'fk_taxonomy_group__phylum_id')->references('id')->on('taxonomy_rank_phylum')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('class_id', 'fk_taxonomy_group__class_id')->references('id')->on('taxonomy_rank_class')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('order_id', 'fk_taxonomy_group__order_id')->references('id')->on('taxonomy_rank_order')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('family_id', 'fk_taxonomy_group__family_id')->references('id')->on('taxonomy_rank_family')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('genus_id', 'fk_taxonomy_group__genus_id')->references('id')->on('taxonomy_rank_genus')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('specie_id', 'fk_taxonomy_group__specie_id')->references('id')->on('taxonomy_rank_specie')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taxonomy_group', function(Blueprint $table)
		{
			$table->dropForeign('fk_taxonomy_group__kingdom_id');
			$table->dropForeign('fk_taxonomy_group__phylum_id');
			$table->dropForeign('fk_taxonomy_group__class_id');
			$table->dropForeign('fk_taxonomy_group__order_id');
			$table->dropForeign('fk_taxonomy_group__family_id');
			$table->dropForeign('fk_taxonomy_group__genus_id');
			$table->dropForeign('fk_taxonomy_group__specie_id');
		});
	}

}
