<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * @group Gestion de User
 *
 * APIs pour gerer des Users
**/
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     * Demande d'acces a l'api, reponse par envoi d'un mail
     */
    public function store(Request $request)
    {
        $validator = validator(
            $request->all(),
            [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'entreprise' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'ville' => 'required|string|max:255',
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
                'entreprise' => "Le nom de l'entreprise",
                'email' => "L'email",
                'ville' => "La ville",
                'adresse' => "L'adresse"

            ]
        );

        try {
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());

            } else {

                DB::beginTransaction();

                $user = User::create($request->all());

                // Créer un jeton API avec Sanctum
                $token = $user->createToken('API Token')->plainTextToken;

                // Mettre à jour la demande avec le jeton
                $user->update([
                    'remember_token' => $token,
                ]);

                // Envoi de l'email avec le jeton API
                Mail::to($user->email)->send(new OrderMail($user));

                DB::commit();

            return redirect()->back()->with('success', 'Votre demande d\'accès à l\'API a été envoyée avec succès. Vous recevrez un email.');
        }

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur s\'est produite');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
