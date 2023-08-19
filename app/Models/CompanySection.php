<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Company $company
 * @property CompanyUser[] $companyUsers
 * @property ProductSale[] $productSales
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $ville
 * @property string $section
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 */
class CompanySection extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'ville', 'section', 'status'];

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
    public function companyUsers()
    {
        return $this->hasMany('App\Models\CompanyUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSales()
    {
        return $this->hasMany('App\Models\ProductSale');
    }
}
