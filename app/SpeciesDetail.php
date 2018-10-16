<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $taxonomy_group_id
 * @property string $species_description
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property TaxonomyGroup $taxonomyGroup
 * @property ArticleSpecie[] $articleSpecies
 * @property PopularName[] $popularNames
 */
class SpeciesDetail extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'species_detail';

    /**
     * @var array
     */
    protected $fillable = ['taxonomy_group_id', 'species_description', 'figure_path', 'created_at', 'updated_at'];

    protected $appends = ['text'];

    public function getTextAttribute() {
        return $this->species_description;
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function popularNames()
    {
        return $this->hasMany('App\PopularName');
    }
}
