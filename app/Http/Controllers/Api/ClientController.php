<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

/**
 * @group Gestion de Client
 *
 * APIs pour gerer les Clients
**/
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * liste des clients
     * @urlParam size integer Taille par page. Par defaut = 20. Example:20
     * @header Authorization Bearer {token}
     */
    public function index(Request $request)
    {
        //Liste de tous les clients

        $size = $request->size ?? 10;
        $clients = Client::paginate($size);

        return response()->json($clients);
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
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'telephone' => 'required|unique:clients,telephone',
                'adresse' => 'required|string|max:255'
            ],
            [
                'required' => ':attribute est obligatoire',
                'string' => ':attribute doit etre une chaine de caractere',
                'email' => ':attribute doit etre un email valide',
                'unique' => ':attribute existe deja',
                'max' => ':attribute ne doit pas depasser :max caracteres.',
            ],
            [
                'nom' => "Le nom",
                'prenom' => "Le prenom",
                'telephone' => "Le numero de telephone",
                'email' => "L'email",
                'adresse' => "L'adresse"

            ]
        );

        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => $validator->errors()->first()], 500);
            } else {

                $client = Client::create($request->all());

                return response()->json([
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Client creer avec succes.',
                    'client' => $client], 201);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur s\'est produite.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
