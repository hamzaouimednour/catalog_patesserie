<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Order[] $orders
 * @property int $id
 * @property string $name
 * @property int $phone
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class Customer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'phone', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
