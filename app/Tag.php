<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $word
 * @property string $created_at
 * @property string $updated_at
 * @property ArticleTag[] $articleTags
 */
class Tag extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tag';

    /**
     * @var array
     */
    protected $fillable = ['word', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleTags()
    {
        return $this->hasMany('App\ArticleTag');
    }
}
