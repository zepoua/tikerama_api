<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class, 'ticket_event_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'ticket_order_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_ticket_type_id');
    }
}
