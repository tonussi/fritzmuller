<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $author_name
 * @property string $author_surname
 * @property string $bio
 * @property string $contact
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property ArticleAuthor[] $articleAuthors
 */
class Author extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'author';

    /**
     * @var array
     */
    protected $fillable = ['author_name', 'author_surname', 'bio', 'contact', 'figure_path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleAuthors()
    {
        return $this->hasMany('App\ArticleAuthor');
    }
}
