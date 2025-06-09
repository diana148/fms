<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', 'service_type_id', 'vehicle_plate_number',
        'device_serial_number', 'installation_date',
        'technician_id', 'status', 'notes'
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // Add a direct client relationship through the contract
    public function client()
    {
        return $this->hasOneThrough(Client::class, Contract::class);
    }
}
