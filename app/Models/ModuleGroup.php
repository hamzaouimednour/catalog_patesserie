<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GroupPermission $groupPermission
 * @property Module $module
 * @property UserPermission[] $userPermissions
 * @property int $id
 * @property int $group_id
 * @property int $module_id
 * @property string $actions
 * @property string $created_at
 * @property string $updated_at
 */
class ModuleGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['group_id', 'module_id', 'actions'];

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
    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPermissions()
    {
        return $this->hasMany('App\Models\UserPermission');
    }
}
