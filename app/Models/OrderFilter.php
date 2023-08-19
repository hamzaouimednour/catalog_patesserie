<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CompanyUser $companyUser
 * @property Order $order
 * @property int $id
 * @property int $company_section_id
 * @property int $order_id
 * @property string $tags
 * @property string $sub_tags
 * @property string $created_at
 * @property string $updated_at
 */
class OrderFilter extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_section_id', 'order_id', 'tags', 'sub_tags'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyUser()
    {
        return $this->belongsTo('App\Models\CompanyUser', 'company_section_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
