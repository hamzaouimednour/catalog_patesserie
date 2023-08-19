<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Product $product
 * @property Size $size
 * @property int $id
 * @property int $product_id
 * @property int $size_id
 * @property float $price
 * @property boolean $default
 * @property boolean $status
 */
class ProductSizePrice extends Model
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
    protected $fillable = ['product_id', 'size_id', 'price', 'default', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }
}
