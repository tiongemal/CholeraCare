<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'supply_id';

    protected $fillable = [
        'supply_name', 'total_quantity'
    ];

    // Relationship: A supply can be used in many reports
    public function suppliesUsed()
    {
        return $this->hasMany(SupplyUsed::class, 'supply_id');
    }

    public function restockRequests()
{
    return $this->hasMany(RestockRequest::class);
}

}
