<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'name', 'description', 'installation_price_tzs', 'installation_price_usd',
        'monthly_price_tzs', 'monthly_price_usd', 'is_active'
    ];

    public function contractServices()
    {
        return $this->hasMany(ContractService::class);
    }

    public function installations()
    {
        return $this->hasMany(Installation::class);
    }

}
