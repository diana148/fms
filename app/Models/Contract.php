<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number', 'client_id', 'start_date', 'end_date',
        'currency', 'total_installation_cost', 'monthly_cost', 'status', 'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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

    /**
     * Get the invoices for the contract.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }

    public function isExpired()
    {
        return $this->end_date < now();
    }
}
