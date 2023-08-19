<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property CompanyUser[] $companyUsers
 * @property UserPermission[] $userPermissions
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $phone
 * @property string $password
 * @property boolean $status
 * @property string $last_login
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable
{
    use Notifiable;
    /**
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'phone', 'password', 'status', 'is_admin', 'last_login', 'remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
    public function userPermissions()
    {
        return $this->hasMany('App\Models\UserPermission');
    }
}
