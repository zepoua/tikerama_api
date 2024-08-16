<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderIntent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Gestion de OrderIntent
 *
 * APIs pour gerer des OrderIntents
**/
class OrderIntentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Liste de toutes les intentions de commandes pour un evenement
     * @urlParam event_id int required Event ID. Example:2
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @header Authorization Bearer {token}
     */
    public function index(Request $request, $event_id)
    {
        //liste des intentions de commandes d'un evenement

        $size = $request->size ?? 10;
        
        $order_intents = OrderIntent::with(['event', 'client'])
                        ->where('order_intent_event_id', $event_id)
                        ->paginate($size);

        return response()->json($order_intents);
    }


    /**
     * Store a newly created resource in storage.
     * @header Authorization Bearer {token}
     */
    public function store(Request $request)
    {
        $validator = validator(

            $request->all(),

            [
                'order_intent_price' => ['required', 'integer', 'min:0'],
                'order_intent_type' => ['required', 'string', 'max:50'],
                'user_email' => ['required', 'string', 'email', 'max:100'],
                'user_phone' => ['required', 'string', 'max:20'],
                'expiration_date' => ['required', 'date', 'after_or_equal:today'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'email' => ':attribute doit etre une adresse email valide.',
                'integer' => ':attribute doit etre un nombre entier.',
                'date' => ':attribute doit etre une date valide.',
                'after_or_equal' => ':attribute doit etre une date ulterieure ou egale a la date actuelle.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
                'min' => ':attribute doit etre au moins :min.',
            ],
            [
                'order_intent_price' => 'Le Prix de la commande',
                'order_intent_type' => 'Le Type de commande',
                'user_email' => 'L\'dresse email',
                'user_phone' => 'Le numero de telephone',
                'expiration_date' => 'Date d\'expiration',
            ]

        );

        try {
            if ($validator->fails()) {
                //si les regles de validation sont respectees

                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => $validator->errors()->first()], 500);
            } else {
                //creation d'une intention de commande

                $orderIntent = OrderIntent::create($request->all());

                return response()->json([
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Intention de commande creer avec succes.',
                    'orderIntent' => $orderIntent], 201);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }

    }


    /**
     * Validation d'une intention de commande
     * @urlParam order_intent_id integer required
     * @header Authorization Bearer {token}
     */
    public function validateIntent($order_intent_id)
    {
        //chercher l'intention de commande concernee
        $orderIntent = OrderIntent::findOrFail($order_intent_id);


        // Validation de l'intention de commande
        // Génération d'une URL pour télécharger les tickets (exemple fictif)

        $order = Order::create([
            'order_number' => 'ORD' . time(),
            'order_event_id' => $orderIntent->order_intent_event_id,
            'order_price' => $orderIntent->order_intent_price,
            'order_type' => $orderIntent->order_intent_type,
            'order_payment' => 'pending', // par exemple
            'order_info' => 'Commande validée',
        ]);

        // URL fictive pour le téléchargement des tickets
        $downloadUrl = route('download.tickets', ['order_id' => $order->order_id]);

        //supression de l'intention de commande
        $orderIntent->delete();

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Intention de commande validée avec succes.',
            'order' => $order,
            'download_url' => $downloadUrl],201);

    }

    /**
     * Display the specified resource.
     * @header Authorization Bearer {token}
     */
    public function show(OrderIntent $orderIntent)
    {
        return response()->json($orderIntent);
    }

    /**
     * Update the specified resource in storage.
     * @header Authorization Bearer {token}
     */
    public function update(Request $request, OrderIntent $orderIntent)
    {
        //regles de validation

        $validator = validator(

            $request->all(),

            [
                'order_intent_price' => ['required', 'integer', 'min:0'],
                'order_intent_type' => ['required', 'string', 'max:50'],
                'user_email' => ['required', 'string', 'email', 'max:100'],
                'user_phone' => ['required', 'string', 'max:20'],
                'expiration_date' => ['required', 'date', 'after_or_equal:today'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'email' => ':attribute doit etre une adresse email valide.',
                'integer' => ':attribute doit etre un nombre entier.',
                'date' => ':attribute doit etre une date valide.',
                'after_or_equal' => ':attribute doit etre une date ulterieure ou egale a la date actuelle.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
                'min' => ':attribute doit etre au moins :min.',
            ],
            [
                'order_intent_price' => 'Le Prix de la commande',
                'order_intent_type' => 'Le Type de commande',
                'user_email' => 'L\'dresse email',
                'user_phone' => 'Le numero de telephone',
                'expiration_date' => 'Date d\'expiration',
            ]

        );

        try {
            //si les regles de validation sont respectees

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => $validator->errors()->first()], 500);
            } else {

                //update d'une intention de commande
                $orderIntent->update($request->all());

                return response()->json([
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Intention de commande mise a jour avec succes.',
                    'orderIntent' => $orderIntent], 201);

            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @header Authorization Bearer {token}
     */
    public function destroy(OrderIntent $orderIntent)
    {
        //suppression d'une intention de commande
        try {

            $orderIntent->delete();

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Intention de commande supprime avec succes.'], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }
}
