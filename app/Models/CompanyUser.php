<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CompanySection $companySection
 * @property User $user
 * @property int $id
 * @property int $company_section_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyUser extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_section_id', 'user_id'];

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
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
        
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderFilters()
    {
        return $this->hasMany('App\Models\OrderFilter');
    }
}
