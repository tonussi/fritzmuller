<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $article_content
 * @property string $publication_date
 * @property boolean $active
 * @property string $title
 * @property float $price
 * @property int $rating
 * @property string $subtitle
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property ArticleAuthor[] $articleAuthors
 * @property ArticleSpecie[] $articleSpecies
 * @property ArticleTag[] $articleTags
 */
class Article extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['article_content', 'publication_date', 'active', 'title', 'price', 'rating', 'subtitle', 'figure_path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleAuthors()
    {
        return $this->hasMany('App\ArticleAuthor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleSpecies()
    {
        return $this->hasMany('App\ArticleSpecie');
    }
}
