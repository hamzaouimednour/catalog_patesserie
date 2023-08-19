<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ModuleGroup[] $moduleGroups
 * @property int $id
 * @property string $module
 * @property boolean $status
 */
class Module extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['module', 'controller', 'actions', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduleGroups()
    {
        return $this->hasMany('App\Models\ModuleGroup');
    }
}
