<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'communication_id';

    protected $fillable = [
        'sender_id', 'receiver_id', 'message_type', 'content', 'sent_at'
    ];

    // Relationship: CommunicationLog belongs to sender (user)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship: CommunicationLog belongs to receiver (user)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
