<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Gestion de Order
 *
 * APIs pour gerer les Orders
**/
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Liste de toutes les commandes
     *@header Authorization Bearer {token}
     */
    public function index()
    {
        //liste des commandes

        return response()->json(Order::all());
    }

    /**
     * Display a listing of the resource.
     * Liste de toutes les commandes pour un evenement
     * @urlParam event_id int required Event ID. Example:2
     * @header Authorization Bearer {token}
     */

    public function eventOrder($event_id)
    {
        //liste des commandes pour un evenement

        return response()->json(Order::where('order_event_id', $event_id));
    }


    /**
     * Store a newly created resource in storage.
     * @header Authorization Bearer {token}
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @header Authorization Bearer {token}
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @header Authorization Bearer {token}
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @header Authorization Bearer {token}
     */
    public function destroy(Order $order)
    {
        //
    }
}
