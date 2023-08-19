<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CompanyAdministration[] $companyAdministrations
 * @property CompanySection[] $companySections
 * @property Component[] $components
 * @property Order[] $orders
 * @property Product[] $products
 * @property Size[] $sizes
 * @property int $id
 * @property string $company_name
 * @property string $description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Company extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'company';

    /**
     * @var array
     */
    protected $fillable = ['company_name', 'description', 'address', 'phone', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyAdministrations()
    {
        return $this->hasMany('App\Models\CompanyAdministration');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companySections()
    {
        return $this->hasMany('App\Models\CompanySection');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function components()
    {
        return $this->hasMany('App\Models\Component');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes()
    {
        return $this->hasMany('App\Models\Size');
    }
}
