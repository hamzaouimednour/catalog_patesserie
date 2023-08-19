<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property Customer $customer
 * @property int $id
 * @property int $company_id
 * @property int $customer_id
 * @property boolean $special
 * @property string $product_components
 * @property string $delivery_date
 * @property string $delivery_mode
 * @property string $delivery_point
 * @property float $acompte
 * @property string $acompte_type
 * @property float $total
 * @property string $instructions
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends Model
{
    /**
     * @var array
     */
    public $timestamps = true;
    
    protected $fillable = ['company_id', 'customer_id', 'special', 'product_components', 'delivery_date', 'delivery_mode', 'delivery_point', 'acompte', 'acompte_type', 'total', 'instructions', 'status', 'order_num'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderFilters()
    {
        return $this->hasMany('App\Models\OrderFilter');
    }
    
}
