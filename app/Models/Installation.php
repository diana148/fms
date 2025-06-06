<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Good practice to include if you use factories

class Installation extends Model
{
    use HasFactory; // Include this if you're using factories

    protected $fillable = [
        'contract_id', 'service_type_id', 'vehicle_plate_number',
        'device_serial_number', 'installation_date',
        'technician_id', 'status', 'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'installation_date' => 'date', // Change from protected $dates
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
