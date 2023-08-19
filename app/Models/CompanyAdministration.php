<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property Company $company
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyAdministration extends Authenticatable
{
    use Notifiable;
    
    protected $guard = 'company_administration';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'email', 'phone', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
