<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIntent extends Model
{
    use HasFactory;

    protected $table = 'orders_intents';
    protected $primaryKey = 'order_intent_id';

    protected $guarded = [];
}
