<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id', 'sender', 'receptor', 'message', 'status', 'cost', 'publish_time'
    ];

    const STATUS = [
        'in_queue' => 1,
        'scheduled' => 2,
        'in_telecom' => 4,
        'in_telecom_2' => 5,
        'failed' => 6,
        'delivered' => 10,
        'suspended' => 11,
        'blocked' => 14
    ];
}
