<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $taxonomy_group_id
 * @property string $specie_description
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property TaxonomyGroup $taxonomyGroup
 * @property ArticleSpecie[] $articleSpecies
 * @property PopularName[] $popularNames
 */
class SpecieDetail extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'specie_detail';

    /**
     * @var array
     */
    protected $fillable = ['taxonomy_group_id', 'specie_description', 'figure_path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyGroup()
    {
        return $this->belongsTo('App\TaxonomyGroup');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleSpecies()
    {
        return $this->hasMany('App\ArticleSpecie', 'species_id');
    }
}
