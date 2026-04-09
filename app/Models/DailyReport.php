<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    protected $fillable = [
        'field_worker_id',
        'location_id',
        'report_date',
        'suspected_cases',
        'confirmed_cases'
    ];

    // Relationship: A daily report belongs to one field worker
    public function fieldWorker()
    {
        return $this->belongsTo(User::class, 'field_worker_id');
    }

    // Relationship: A daily report belongs to one location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Relationship: A daily report has many supplies used
    public function suppliesUsed()
    {
        return $this->hasMany(SupplyUsed::class, 'report_id');
    }

    // Relationship: A daily report can have multiple cases
    public function cases()
{
    return $this->hasMany(CaseReport::class, 'report_id');
}

}
