<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GroupPermission $groupPermission
 * @property User $user
 * @property int $id
 * @property int $group_id
 * @property int $user_id
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserPermission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['group_id', 'user_id', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupPermission()
    {
        return $this->belongsTo('App\Models\GroupPermission', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
