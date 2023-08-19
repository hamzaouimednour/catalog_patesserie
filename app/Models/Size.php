<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property ProductComponentPrice[] $productComponentPrices
 * @property ProductSizePrice[] $productSizePrices
 * @property int $id
 * @property int $company_id
 * @property string $size_name
 * @property boolean $status
 */
class Size extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'size_name', 'status'];

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
    public function productComponentPrices()
    {
        return $this->hasMany('App\Models\ProductComponentPrice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSizePrices()
    {
        return $this->hasMany('App\Models\ProductSizePrice');
    }
}
