<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $article_content
 * @property string $publication_date
 * @property boolean $active
 * @property string $title
 * @property string $subtitle
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property ArticleSpecie[] $articleSpecies
 * @property ArticleAuthor[] $articleAuthors
 * @property ArticleTag[] $articleTags
 */
class Article extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['article_content', 'publication_date', 'active', 'title', 'subtitle', 'figure_path', 'rating', 'price', 'created_at', 'updated_at'];

    protected $appends = ['flex', 'show'];

    public function getFlexAttribute() {
        return 4;
    }

    public function getShowAttribute() {
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleSpecies()
    {
        return $this->hasMany('App\ArticleSpecie');
    }

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
    public function articleTags()
    {
        return $this->hasMany('App\ArticleTag');
    }
}
