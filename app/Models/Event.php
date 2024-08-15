<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'event_id';

    protected $guarded = [];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_event_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'ticket_type_event_id');
    }
}
