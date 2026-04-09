<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyUsed extends Model
{
    use HasFactory;

    protected $table = 'supplies_used';

    protected $primaryKey = 'supply_use_id';


    protected $fillable = [
        'report_id', 'supply_id', 'quantity_used'
    ];

    // Relationship: SupplyUsed belongs to one report
    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class, 'report_id');
    }

    // Relationship: SupplyUsed belongs to one supply
    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }
}
