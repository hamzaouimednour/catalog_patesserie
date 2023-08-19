<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ComponentGroup $componentGroup
 * @property Component $component
 * @property Product $product
 * @property int $id
 * @property int $component_group_id
 * @property int $component_id
 * @property int $product_id
 * @property boolean $status
 * @property string $usage
 * @property string $created_at
 * @property string $updated_at
 */
class ProductComponentGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['component_group_id', 'component_id', 'product_id', 'status', 'usage'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function componentGroup()
    {
        return $this->belongsTo('App\Models\ComponentGroup');
    }

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
}
