<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property ProductComponentGroup[] $productComponentGroups
 * @property ProductComponent[] $productComponents
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $category
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class Component extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'category', 'img', 'status'];

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
    public function productComponentGroups()
    {
        return $this->hasMany('App\Models\ProductComponentGroup');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productComponents()
    {
        return $this->hasMany('App\Models\ProductComponent');
    }
}
