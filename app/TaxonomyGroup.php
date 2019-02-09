<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $kingdom_id
 * @property int $phylum_id
 * @property int $class_id
 * @property int $order_id
 * @property int $family_id
 * @property int $genus_id
 * @property int $specie_id
 * @property string $created_at
 * @property string $updated_at
 * @property TaxonomyRankClass $taxonomyRankClass
 * @property TaxonomyRankFamily $taxonomyRankFamily
 * @property TaxonomyRankGenus $taxonomyRankGenus
 * @property TaxonomyRankKingdom $taxonomyRankKingdom
 * @property TaxonomyRankOrder $taxonomyRankOrder
 * @property TaxonomyRankPhylum $taxonomyRankPhylum
 * @property TaxonomyRankSpecie $taxonomyRankSpecie
 * @property SpecieDetail[] $specieDetails
 */
class TaxonomyGroup extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taxonomy_group';

    /**
     * @var array
     */
    protected $fillable = ['kingdom_id', 'phylum_id', 'class_id', 'order_id', 'family_id', 'genus_id', 'specie_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankClass()
    {
        return $this->belongsTo('App\TaxonomyRankClass', 'class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankFamily()
    {
        return $this->belongsTo('App\TaxonomyRankFamily', 'family_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankGenus()
    {
        return $this->belongsTo('App\TaxonomyRankGenus', 'genus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankKingdom()
    {
        return $this->belongsTo('App\TaxonomyRankKingdom', 'kingdom_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankOrder()
    {
        return $this->belongsTo('App\TaxonomyRankOrder', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankPhylum()
    {
        return $this->belongsTo('App\TaxonomyRankPhylum', 'phylum_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomyRankSpecie()
    {
        return $this->belongsTo('App\TaxonomyRankSpecie', 'specie_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specieDetails()
    {
        return $this->hasMany('App\SpecieDetail');
    }
}
