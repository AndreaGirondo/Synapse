<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
// use App\Http\Requests\LogUserRequest;
// use App\Http\Requests\UserUpdate;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\User;

class UserController extends Controller
{
    public function register(RegisterUser $request)
    {
        try{
            $user = new User();
            $user->name = e($request->name); // e() permet de protéger les données qui pourrai échapper (HTML) cela est pour contrer les attaques XSS
            $user->email = e($request->email);
            $user->password = e($request->password);
            $user->save();

            return response()->json([
                'status_code'=>201,  
                'status_message'=>'L\'utilisateur a bien été créé',
                'user'=>$user
            ]);

        }catch(Exception $e)
        {
            Log::error($e); // Log permet de sauvegarder les erreurs dans un fichier de log
        
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Une erreur est survenue. Veuillez réessayer plus tard.',
            ]);
        }
    }

    // public function login(LogUserRequest $request){
    //     if(auth()->attempt($request->only(['email','password']))){ /* verification de la cohérence du mail et du mot de passe a un user pour le conecter, si les information son vrai, attempt renvera true */

    //         $user = auth()->user();
    //         $token = $user->createToken('MA_CLEF_SECRETE_VISIBLE_AU_BACK')->plainTextToken;

    //         return response()->json([
    //             'status_code'=>201,  
    //             'status_message'=>'Utilisateur connecté',
    //             'user'=>$user,
    //             'token'=>$token
    //         ]);

    //     }else{
    //         return response()->json([
    //             'status_code'=>403,  
    //             'status_message'=>'Information non valide',
    //         ]);
    //     }
    // }

    // public function update(UserUpdate $request, $id)
    // {
    //     try {
    //         $user = User::find($id);

    //         if (Auth::id() != $user->id) {
    //             return response()->json([
    //                 'status_code' => 403,
    //                 'status_message' => 'Vous ne pouvez mettre à jour que votre propre compte',
    //             ]);
    //         }

    //         $user->fill($request->all());
    //         $user->save();

    //         return response()->json([
    //             'status_code' => 201,
    //             'status_message' => 'L\'utilisateur a bien été mis à jour',
    //             'user' => $user
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([$e]);
    //     }
    // }

    // public function delete($id){
    //     try{
    //         $user = User::find($id); // On récupère l'utilisateur à supprimer
    
    //         if (Auth::id() != $user->id) { // Auth::id() permet de récupérer l'id de l'utilisateur actuellement connecté
    //             return response()->json([
    //                 'status_code'=>403,  
    //                 'status_message'=>'Vous ne pouvez supprimer que votre propre compte',
    //             ]);
    //         }
    
    //         $user->delete();
    
    //         return response()->json([
    //             'status_code'=>201,  
    //             'status_message'=>'L\'utilisateur a bien été supprimé',
    //             'user'=>$user
    //         ]);
    
    //     }catch(Exception $e)
    //     {
    //         return response()->json([$e]);
    // //     }
    // }
}
