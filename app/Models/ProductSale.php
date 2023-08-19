<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CompanySection $companySection
 * @property Product $product
 * @property int $id
 * @property int $company_section_id
 * @property int $product_id
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class ProductSale extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_section_id', 'product_id', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companySection()
    {
        return $this->belongsTo('App\Models\CompanySection');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
