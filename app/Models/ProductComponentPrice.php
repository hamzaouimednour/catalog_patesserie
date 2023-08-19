<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ProductComponent $productComponent
 * @property Size $size
 * @property int $id
 * @property int $product_component_id
 * @property int $size_id
 * @property float $price
 */
class ProductComponentPrice extends Model
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
    protected $fillable = ['product_component_id', 'size_id', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productComponent()
    {
        return $this->belongsTo('App\Models\ProductComponent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }
}
