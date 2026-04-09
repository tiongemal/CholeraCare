<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';
    protected $primaryKey = 'location_id';

    protected $fillable = [
        'location_name',
        'region',
    ];

    // Relationship: A location can have many field workers
    public function fieldWorkers()
    {
        return $this->hasMany(User::class, 'location_id');
    }

    // Relationship: A location can have multiple daily reports
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class, 'location_id');
    }

    public function location()
{
    return $this->belongsTo(Location::class, 'location_id', 'id'); // Adjust 'id' based on your actual primary key in the locations table
}
}
