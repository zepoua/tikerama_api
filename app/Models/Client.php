<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'client_id';

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_client_id');
    }

    public function orderIntents()
    {
        return $this->hasMany(OrderIntent::class, 'order_intent_client_id');
    }
}
