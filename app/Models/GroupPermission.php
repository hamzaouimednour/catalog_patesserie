<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property ModuleGroup[] $moduleGroups
 * @property UserPermission[] $userPermissions
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class GroupPermission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduleGroups()
    {
        return $this->hasMany('App\Models\ModuleGroup', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPermissions()
    {
        return $this->hasMany('App\Models\UserPermission', 'group_id');
    }
}
