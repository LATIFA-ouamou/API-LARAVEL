<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{
    public function register (Request $request){
        $infos=$request->validate([

            'name'=>'required|min:3',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:3|confirmed',
        ]);

         // Hachage du mot de passe avant enregistrement
    $infos['password'] = Hash::make($infos['password']);
$user= User::create($infos);
$token=$user->createToken($request->name);
return [
    'user'=> $user,
    'token'=>$token->plainTextToken,

];
    
}
 public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }


public function logout(Request $request){
$request->user()->tokens()->delete();
        return response()->json(['message' => 'Déconnecté avec succès']);

}
public function test(){
    return 'bienvenu';
    
}


}