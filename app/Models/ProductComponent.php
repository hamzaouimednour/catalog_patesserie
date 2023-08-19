<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Component $component
 * @property Product $product
 * @property ProductComponentPrice[] $productComponentPrices
 * @property int $id
 * @property int $component_id
 * @property int $product_id
 * @property boolean $price_by_size
 * @property float $default_price
 * @property string $img
 * @property string $usage
 * @property boolean $status
 */
class ProductComponent extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['component_id', 'product_id', 'price_by_size', 'default_price', 'img', 'usage', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component()
    {
        return $this->belongsTo('App\Models\Component');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productComponentPrices()
    {
        return $this->hasMany('App\Models\ProductComponentPrice');
    }
}
