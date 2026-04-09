<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'sync_id';

    protected $fillable = [
        'field_worker_id', 'last_sync'
    ];

    // Relationship: SyncLog belongs to one field worker
    public function fieldWorker()
    {
        return $this->belongsTo(User::class, 'field_worker_id');
    }
}
