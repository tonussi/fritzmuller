<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $specie_id
 * @property int $article_id
 * @property string $created_at
 * @property string $updated_at
 * @property Article $article
 * @property SpecieDetail $specieDetail
 */
class ArticleSpecie extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'article_specie';

    /**
     * @var array
     */
    protected $fillable = ['specie_id', 'article_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specieDetail()
    {
        return $this->belongsTo('App\SpecieDetail', 'specie_id');
    }
}
