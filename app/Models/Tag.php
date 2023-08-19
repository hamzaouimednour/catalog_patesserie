<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property ProductTag[] $productTags
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class Tag extends Model
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
    public function productTags()
    {
        return $this->hasMany('App\Models\ProductTag');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subTags()
    {
        return $this->hasMany('App\Models\SubTag');
    }
}
