<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockRequest extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'restock_requests';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'supply_id',
        'user_id',
        'quantity_left',
        'location_id'
    ];

    // Define the relationship with the Supply model
    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supply_id', 'supply_id');
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id'); // Assuming the primary key in the locations table is 'id'
    }
}
