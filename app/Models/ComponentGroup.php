<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property ProductComponentGroup[] $productComponentGroups
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class ComponentGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'description', 'usage', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productComponentGroups()
    {
        return $this->hasMany('App\Model\ProductComponentGroup');
    }
}
