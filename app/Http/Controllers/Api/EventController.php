<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Liste de tous les evenements par ordre decroissant de date et pagine par 10...

        $events = Event::orderBy('event_date', 'DESC')->paginate(10);

        return response()->json($events);
    }

    public function upcomingEvents()
    {
        //Liste de tous les evenements en cours par ordre decroissant de date et pagine par 10...

        $events = Event::where('event_status', '==', 'upcoming')
                        ->orderBy('event_date', 'DESC')
                        ->paginate(10);

        return response()->json($events);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //regles de validation

        $validator = validator(

            $request->all(),

            [
                'event_category' => ['required', 'string', 'in:Autre,Concert-Spectacle,Diner Gala,Festival,Formation'],
                'event_title' => ['required', 'string', 'max:30'],
                'event_description' => ['required', 'string'],
                'event_date' => ['required', 'date', 'after_or_equal:today'],
                'event_image' => ['required', 'mimes:jpeg,png,jpg'],
                'event_city' => ['required', 'string', 'max:100'],
                'event_address' => ['required', 'string', 'max:200'],
                'event_status' => ['required', 'string', 'in:upcoming,completed'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'in' => ':attribute doit etre l\'une des valeurs suivantes : :values.',
                'mimes' => ':attribute doit etre un fichier de type : :values.',
                'after_or_equal' => ':attribute doit etre une date egale ou posterieure e aujourd\'hui.',
                'date' => ':attribute doit etre une date valide.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
            ],
            [
                'event_category' => "La categorie",
                'event_title' => "Le titre",
                'event_description' => "La description",
                'event_date' => "La date",
                'event_image' => "L'image'",
                'event_city' => "La ville",
                'event_address' => "L'adresse",
                'event_status' => "Le status",
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
                //creation d'un nouveau evenement
                    $image = $request->event_image->getClientOriginalName();
                    $request->event_image->move(public_path('images'), $image);
                    $eventData = $request->except('event_image');
					$eventData['event_image'] = $image;
                    $event = Event::create($eventData);

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Evenement creer avec succes.',
                        'event' => $event], 201);
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
     */
    public function show(Event $event)
    {
        //Detail d'un evenement...

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //regles de validation

        $validator = validator(

            $request->all(),

            [
                'event_category' => ['required', 'string', 'in:Autre,Concert-Spectacle,Diner Gala,Festival,Formation'],
                'event_title' => ['required', 'string', 'max:30'],
                'event_description' => ['required', 'string'],
                'event_date' => ['required', 'date', 'after_or_equal:today'],
                'event_image' => ['required', 'mimes:jpeg,png,jpg'],
                'event_city' => ['required', 'string', 'max:100'],
                'event_address' => ['required', 'string', 'max:200'],
                'event_status' => ['required', 'string', 'in:upcoming,completed'],
            ],
            [
                'required' => ':attribute est obligatoire.',
                'string' => ':attribute doit etre une chaine de caracteres.',
                'in' => ':attribute doit etre l\'une des valeurs suivantes : :values.',
                'mimes' => ':attribute doit etre un fichier de type : :values.',
                'after_or_equal' => ':attribute doit etre une date egale ou posterieure e aujourd\'hui.',
                'date' => ':attribute doit etre une date valide.',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
            ],
            [
                'event_category' => "La categorie",
                'event_title' => "Le titre",
                'event_description' => "La description",
                'event_date' => "La date",
                'event_image' => "L'image'",
                'event_city' => "La ville",
                'event_address' => "L'adresse",
                'event_status' => "Le status",
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
                //creation d'un nouveau evenement
                    $old_image = $event->event_image;

                    // Mise à jour des données sauf l'image
                    $event->update($request->except('event_image'));

                    // Validation et sauvegarde de la nouvelle image si elle est fournie
                    if ($request->hasFile('event_image') && $request->file('event_image')->getClientOriginalName() !== $old_image) {
                        $image = $request->file('event_image')->getClientOriginalName();
                        $request->file('event_image')->move(public_path('images'), $image);
                        $event->event_image = $image;
                        $event->save();
                    }

                    return response()->json([
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Evenement mise a jour avec succes.',
                        'event' => $event], 201);
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
     */
    public function destroy(Event $event)
    {
        //annulation d'un evenement

        try {

            $event->update(['event_status', 'cancelled']);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Evenement annule avec succes.',
                'event' => $event], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }
}
