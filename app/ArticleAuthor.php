<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $author_id
 * @property int $article_id
 * @property string $created_at
 * @property string $updated_at
 * @property Author $author
 * @property Article $article
 */
class ArticleAuthor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'article_author';

    /**
     * @var array
     */
    protected $fillable = ['author_id', 'article_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
