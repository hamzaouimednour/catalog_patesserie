<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Product $product
 * @property Tag $tag
 * @property int $id
 * @property int $product_id
 * @property int $tag_id
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class ProductTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['product_id', 'tag_id', 'status'];

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
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }
}
