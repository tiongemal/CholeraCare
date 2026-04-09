<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Extend from Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Corrected the class to extend from Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'fullname',
        'password',
        'email',
        'role',
        'location_id',
        'status'
    ];

    // Relationship: A user (field staff) belongs to one location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Relationship: A field worker can have multiple daily reports
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class, 'field_worker_id');
    }

    // Relationship: Communication logs
    public function sentMessages()
    {
        return $this->hasMany(CommunicationLog::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(CommunicationLog::class, 'receiver_id');
    }

    public function restockRequests()
{
    return $this->hasMany(RestockRequest::class);
}

}
