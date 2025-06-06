<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractService extends Model
{
    protected $fillable = [
        'contract_id', 'service_type_id', 'quantity',
        'unit_installation_price', 'unit_monthly_price',
        'total_installation_cost', 'total_monthly_cost'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

}
