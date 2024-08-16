<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

/**
 * @group Gestion de Ticket
 *
 * APIs pour gerer des Tickets
**/
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * Liste des tickets pour un evenement
     * @urlParam event_id int required Event ID. Example:2
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @header Authorization Bearer {token}
     */
    public function index(Request $request, $event_id)
    {
        //liste d'un ticket pour un evenement

        $size = $request->size ?? 10;

        $tickets = Ticket::with(['event', 'ticket_types'])
                        ->where('ticket_event_id', $event_id)
                        ->paginate($size);

        return response()->json($tickets);
    }

    /**
     * Display a listing of the resource.
     * Liste des tickets pour un evenement et un type de tycke specifique
     * @urlParam event_id int required Event ID. Example:2
     * @urlParam ticket_type_id int required TicketType ID. Example:2
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @header Authorization Bearer {token}
     */
    public function ticketEvent(Request $request, $event_id, $ticket_type_id)
    {
        //liste d'un ticket pour un evenement et un type de tycke specifique

        $size = $request->size ?? 10;

        $tickets = Ticket::with(['event', 'ticket_types'])
                        ->where('ticket_event_id', $event_id)
                        ->where('ticket_ticket_type_id', $ticket_type_id)
                        ->paginate($size);

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     * @header Authorization Bearer {token}
     */
    public function store(Request $request)
    {
        //regles de validation

        $validator = validator(

            $request->all(),

            [
                'ticket_event_id' => ['required', 'integer', 'exists:events,event_id'],
                'ticket_email' => ['required', 'string', 'email', 'max:255'],
                'ticket_phone' => ['required', 'string', 'max:20'],
                'ticket_price' => ['required', 'integer', 'min:0'],
                'ticket_order_id' => ['required', 'integer', 'exists:orders,order_id'],
                'ticket_key' => ['required', 'string', 'max:100', 'unique:tickets,ticket_key'],
                'ticket_ticket_type_id' => ['required', 'integer', 'exists:ticket_types,ticket_type_id'],
                'ticket_status' => ['required', 'in:active,validated,expired,cancelled'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'email' => ':attribute doit etre une adresse email valide.',
                'integer' => ':attribute doit etre un nombre entier.',
                'exists' => ':attribute doit exister dans la table correspondante.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
                'min' => ':attribute doit etre au moins :min.',
                'unique' => ':attribute doit etre unique.',
                'in' => ':attribute doit etre l\'une des valeurs suivantes: :values.',
            ],
            [
                'ticket_event_id' => "L'evenement",
                'ticket_email' => "L'email",
                'ticket_phone' => "Le numero de telephone",
                'ticket_price' => "Le prix",
                'ticket_order_id' => "La commande'",
                'ticket_key' => "La cle",
                'ticket_ticket_type_id' => "Le type de ticket",
                'ticket_status' => "Le status",
            ]
        );

        try {
            //si les regles de validation sont respectees
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => $validator->errors()->first()], 500);
            }else{
                //creation de ticket
                    $ticket = Ticket::create($request->all());

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Ticket creer avec succes.',
                        'type$ticket' => $ticket], 201);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }

    /**
     * Display the specified resource.
     * @header Authorization Bearer {token}
     */
    public function show(Ticket $ticket)
    {
        return response()->json($ticket);
    }

    /**
     * Update the specified resource in storage.
     * @header Authorization Bearer {token}
     */
    public function update(Request $request, Ticket $ticket)
    {
        //regles de validation

        $validator = validator(

            $request->all(),

            [
                'ticket_event_id' => ['required', 'integer', 'exists:events,event_id'],
                'ticket_email' => ['required', 'string', 'email', 'max:255'],
                'ticket_phone' => ['required', 'string', 'max:20'],
                'ticket_price' => ['required', 'integer', 'min:0'],
                'ticket_order_id' => ['required', 'integer', 'exists:orders,order_id'],
                'ticket_key' => ['required', 'string', 'max:100', Rule::unique('tickets', 'ticket_key')->ignore($ticket->ticket_key)],
                'ticket_ticket_type_id' => ['required', 'integer', 'exists:ticket_types,ticket_type_id'],
                'ticket_status' => ['required', 'in:active,validated,expired,cancelled'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'email' => ':attribute doit etre une adresse email valide.',
                'integer' => ':attribute doit etre un nombre entier.',
                'exists' => ':attribute doit exister dans la table correspondante.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
                'min' => ':attribute doit etre au moins :min.',
                'unique' => ':attribute doit etre unique.',
                'in' => ':attribute doit etre l\'une des valeurs suivantes: :values.',
            ],
            [
                'ticket_event_id' => "L'evenement",
                'ticket_email' => "L'email",
                'ticket_phone' => "Le numero de telephone",
                'ticket_price' => "Le prix",
                'ticket_order_id' => "La commande'",
                'ticket_key' => "La cle",
                'ticket_ticket_type_id' => "Le type de ticket",
                'ticket_status' => "Le status",
            ]
        );

        try {
            //si les regles de validation sont respectees
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => $validator->errors()->first()], 500);
            }else{
                //creation de ticket
                    $ticket->update($request->all());

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Ticket Mise a jour avec succes.',
                        'type$ticket' => $ticket], 201);
            }
        }catch (\Throwable $th) {
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
    public function destroy(Ticket $ticket)
    {
        //suppression d'un type de ticket
        try {

            $ticket->delete();

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Ticket supprime avec succes.'], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }
}
