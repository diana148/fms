<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Good practice to include if you use factories

class Contract extends Model
{
    // If you use model factories, include this trait
    use HasFactory;

    protected $fillable = [
        'contract_number', 'client_id', 'start_date', 'end_date',
        'currency', 'total_installation_cost', 'monthly_cost', 'status', 'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date', // Casts to a Carbon date object (no time)
        'end_date' => 'date',   // Casts to a Carbon date object (no time)
        // You can add other casts here, e.g., 'is_active' => 'boolean'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function contractServices()
    {
        return $this->hasMany(ContractService::class);
    }

    public function installations()
    {
        return $this->hasMany(Installation::class);
    }

    // These methods are good and will work with Carbon dates after casting
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }

    public function isExpired()
    {
        return $this->end_date < now();
    }
}
