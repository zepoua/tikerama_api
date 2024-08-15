<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderIntentController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'abilities:check-status,place-orders'])->group(function () {

    //route ressource pour les events (index, store, show, update, destroy)
    Route::apiResource('events', EventController::class);
    //route pour les events en cours
    Route::get('up_events', [EventController::class, 'upcomingEvents']);

    //route ressource pour les tickets (store, show, update, destroy)
    Route::apiResource('tickets', TicketController::class);
    //route pour les tickets d'un event
    Route::get('tick_event/{event_id}', [TicketController::class, 'index']);
    //route pour les tickets d'un event suivant le type de ticket
    Route::get('ticket_event/{event_id}/{ticket_type_id}', [TicketController::class, 'ticketEvent']);

    //route ressource pour les type de tickets (store, show, update, destroy)
    Route::apiResource('ticket_types', TicketTypeController::class);
    //route pour les type de tickets d'un event
    Route::get('tick_type_event/{event_id}', [TicketTypeController::class, 'index']);

    //route ressource pour les intentions de commandes (store, show, update, destroy)
    Route::apiResource('order_intents', OrderIntentController::class);
    //route pour les intentions de commande d'un event
    Route::get('order_intents_event/{event_id}', [OrderIntentController::class, 'index']);
    //route pour la validation d'une intention de commande
    Route::post('validate_order_intents/{order_intent_id}', [OrderIntentController::class, 'validateIntent']);

    //route ressource pour les commandes (index, store, show, update, destroy)
    Route::apiResource('order', OrderController::class);
    //route des commande pour un event
    Route::get('order_event/{event_id}', [OrderController::class, 'index']);

});

