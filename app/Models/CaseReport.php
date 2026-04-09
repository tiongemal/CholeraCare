<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReport extends Model
{
    use HasFactory;

    protected $table = 'cases';
    protected $primaryKey = 'case_id';

    protected $fillable = [
        'case_status',
        'patient_age',
        'patient_gender',
        'supplies_used',
        'reported_at'
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class, 'report_id');
    }
}
