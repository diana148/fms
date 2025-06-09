<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    protected $fillable = [
        'company_name', 'contact_person', 'email', 'phone',
        'address', 'number_of_vehicles', 'status'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the invoices for the client.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
