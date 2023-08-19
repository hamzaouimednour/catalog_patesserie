<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Product $product
 * @property int $id
 * @property int $product_id
 * @property string $img
 */
class ProductImg extends Model
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
    protected $fillable = ['product_id', 'img', 'thumb'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
