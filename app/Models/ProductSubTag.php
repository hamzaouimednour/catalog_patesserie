<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Product $product
 * @property SubTag $subTag
 * @property int $id
 * @property int $product_id
 * @property int $sub_tag_id
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class ProductSubTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['product_id', 'sub_tag_id', 'status'];

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
    public function subTag()
    {
        return $this->belongsTo('App\Models\SubTag');
    }
}
