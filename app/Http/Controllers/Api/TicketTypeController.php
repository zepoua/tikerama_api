<?php

namespace App\Http\Controllers\Api;

use App\Models\TicketType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Gestion de TicketType
 *
 * APIs pour gerer des TicketTypes
**/
class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * Liste des tickets pour un evenement
     * @urlParam event_id int required Event ID. Example:2
     * @header Authorization Bearer {token}
     */
    public function index($event_id)
    {
        //liste des types de tickets disponibles pour un événement donné

        $ticketTypes = TicketType::where('ticket_type_event_id', $event_id)->get();
        return response()->json($ticketTypes);
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
                'ticket_type_event_id' => ['required', 'integer', 'exists:events,event_id'],
                'ticket_type_name' => ['required', 'string', 'max:50'],
                'ticket_type_price' => ['required', 'integer', 'min:0'],
                'ticket_type_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_real_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_total_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_description' => ['nullable', 'string'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit être une chaîne de caractères.',
                'integer' => ':attribute doit être un nombre entier.',
                'exists' => ':attribute doit correspondre à un événement valide.',
                'max' => ':attribute ne doit pas dépasser :max caractères.',
                'min' => ':attribute doit être au moins :min.',
            ],
            [
                'ticket_type_event_id' => "L'evenement",
                'ticket_type_name' => "Le titre",
                'ticket_type_price' => "Le prix",
                'ticket_type_quantity' => "La quantite",
                'ticket_type_real_quantity' => "La quantite reelle'",
                'ticket_type_description' => "La description",
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
                //creation d'un type de ticket
                    $ticketType = TicketType::create($request->all());

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Type de ticket creer avec succes.',
                        'type$ticketType' => $ticketType], 201);
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
    public function show(TicketType $ticketType)
    {
        //detail d'un type de ticket

        return response()->json($ticketType);
    }

    /**
     * Update the specified resource in storage.
     * @header Authorization Bearer {token}
     */
    public function update(Request $request, TicketType $ticketType)
    {
        $validator = validator(

            $request->all(),

            [
                'ticket_type_event_id' => ['required', 'integer', 'exists:events,event_id'],
                'ticket_type_name' => ['required', 'string', 'max:50'],
                'ticket_type_price' => ['required', 'integer', 'min:0'],
                'ticket_type_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_real_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_total_quantity' => ['required', 'integer', 'min:0'],
                'ticket_type_description' => ['nullable', 'string'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit être une chaîne de caractères.',
                'integer' => ':attribute doit être un nombre entier.',
                'exists' => ':attribute doit correspondre à un événement valide.',
                'max' => ':attribute ne doit pas dépasser :max caractères.',
                'min' => ':attribute doit être au moins :min.',
            ],
            [
                'ticket_type_event_id' => "L'evenement",
                'ticket_type_name' => "Le titre",
                'ticket_type_price' => "Le prix",
                'ticket_type_quantity' => "La quantite",
                'ticket_type_real_quantity' => "La quantite reelle'",
                'ticket_type_description' => "La description",
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
                //creation d'un type de ticket
                    $ticketType->update($request->all());

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Type de ticket mise a jour avec succes.',
                        'type$ticketType' => $ticketType], 201);
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
    public function destroy(TicketType $ticketType)
    {
        //suppression d'un type de ticket
        try {

            $ticketType->delete();

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Type de ticket supprime avec succes.'], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }
}
