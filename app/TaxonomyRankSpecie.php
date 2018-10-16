<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $rank_name
 * @property string $created_at
 * @property string $updated_at
 * @property TaxonomyGroup[] $taxonomyGroups
 */
class TaxonomyRankSpecie extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taxonomy_rank_specie';

    /**
     * @var array
     */
    protected $fillable = ['rank_name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxonomyGroups()
    {
        return $this->hasMany('App\TaxonomyGroup', 'specie_id');
    }
}
