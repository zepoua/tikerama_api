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
     * Liste de toutes les commandes d'un client
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     *@header Authorization Bearer {token}
     */
    public function index(Request $request)
    {
        //liste des commandes

        $size = $request->size ?? 10;
        return response()->json(Order::paginate($size));
    }

    /**
     * Display a listing of the resource.
     * Liste de toutes les commandes d'un client
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @urlParam client_id int required Client ID. Example:2
     *@header Authorization Bearer {token}
     */
    public function clientOrders(Request $request, $client_id)
    {
        //liste des commandes d'un client

        $size = $request->size ?? 10;
        $orders = Order::with(['event', 'client'])
                    ->where('order_client_id', $client_id)
                    ->paginate($size);

        return response()->json($orders);
    }



    /**
     * Display a listing of the resource.
     * Liste de toutes les commandes pour un evenement
     * @urlParam event_id int required Event ID. Example:2
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @header Authorization Bearer {token}
     */

    public function eventOrder(Request $request, $event_id)
    {
        //liste des commandes pour un evenement

        $size = $request->size ?? 10;
        $orders = Order::with(['event', 'client'])
                       ->where('order_event_id', $event_id)
                       ->paginate($size);

        return response()->json($orders);
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
        return response()->json($order);
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
