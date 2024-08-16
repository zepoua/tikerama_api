<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIntent extends Model
{
    use HasFactory;

    protected $table = 'order_intents';
    protected $primaryKey = 'order_intent_id';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class, 'order_event_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'order_client_event_id');
    }
}
