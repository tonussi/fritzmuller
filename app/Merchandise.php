<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $figure_path
 * @property string $title
 * @property string $activity_description
 * @property string $target_url
 * @property boolean $active
 * @property string $created_at
 * @property string $updated_at
 */
class Merchandise extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'merchandise';

    /**
     * @var array
     */
    protected $fillable = ['figure_path', 'title', 'activity_description', 'target_url', 'active', 'created_at', 'updated_at'];

}
