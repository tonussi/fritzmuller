<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $species_detail_id
 * @property string $popular_name
 * @property string $created_at
 * @property string $updated_at
 * @property SpeciesDetail $speciesDetail
 */
class PopularName extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'popular_name';

    /**
     * @var array
     */
    protected $fillable = ['species_detail_id', 'popular_name', 'created_at', 'updated_at'];

    // protected $appends = ['text'];

    // public function getTextAttribute() {
    //     return $this->popular_name;
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function speciesDetail()
    {
        return $this->belongsTo('App\SpeciesDetail');
    }
}
