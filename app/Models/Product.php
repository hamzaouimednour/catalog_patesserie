<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Company $company
 * @property ProductComponentGroup[] $productComponentGroups
 * @property ProductComponent[] $productComponents
 * @property ProductImg[] $productImgs
 * @property ProductSale[] $productSales
 * @property ProductSizePrice[] $productSizePrices
 * @property ProductTag[] $productTags
 * @property int $id
 * @property int $company_id
 * @property string $ref
 * @property string $name
 * @property boolean $price_by_size
 * @property float $default_price
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends Model
{
    // use SoftDeletes;

    // protected $dates = ['deleted_at'];
    
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'ref', 'name', 'price_by_size', 'default_price', 'description', 'status'];

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
    public function productComponentGroups()
    {
        return $this->hasMany('App\Models\ProductComponentGroup');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productComponents()
    {
        return $this->hasMany('App\Models\ProductComponent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productImgs()
    {
        return $this->hasMany('App\Models\ProductImg');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSales()
    {
        return $this->hasMany('App\Models\ProductSale');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSizePrices()
    {
        return $this->hasMany('App\Models\ProductSizePrice');
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
    public function productSubTags()
    {
        return $this->hasMany('App\Models\ProductSubTag');
    }
}
