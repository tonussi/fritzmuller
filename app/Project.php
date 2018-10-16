<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $project_description
 * @property string $figure_path
 * @property string $project_name
 * @property string $created_at
 * @property string $updated_at
 * @property Member[] $members
 */
class Project extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'project';

    /**
     * @var array
     */
    protected $fillable = ['project_description', 'figure_path', 'project_name', 'created_at', 'updated_at'];

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
    public function members()
    {
        return $this->hasMany('App\Member');
    }
}
