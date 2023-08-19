<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Tag $tag
 * @property int $id
 * @property int $tag_id
 * @property string $name
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class SubTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tag_id', 'name', 'img', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }
}
