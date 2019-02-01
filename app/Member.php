<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property string $member_name
 * @property string $member_description
 * @property string $grad
 * @property string $figure_path
 * @property string $created_at
 * @property string $updated_at
 * @property Project $project
 */
class Member extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'member';

    /**
     * @var array
     */
    protected $fillable = ['project_id', 'member_name', 'member_description', 'grad', 'figure_path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
