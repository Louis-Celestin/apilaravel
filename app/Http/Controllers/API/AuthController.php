<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\user;
use Validator;

class AuthController extends Controller
{
    //

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8'
        ]);

        if ($validator->fails()){

            return response()->json($validator-errors());
        }

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['data'=>$user, 'access_token'=>$token, 'token_type'=>'Bearer',]);
  
        }

        public function login(Request $request)
        {
            if (!Auth::attempt($request->only('email', 'password'))){

                return response()->json(['message'=>'Non Autorisé'], 404);
            }

            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['mesaage'=>'Bonjour '.$user->name.' vous êtes bien autorisé a utiliser cette API, votre acces token :'.$token, 'token_type'=>'Bearer']);
         }


         public function logout(){

            auth()->user()->tokens()->delete();

            return [
                'message'=>'Connecé et jeton supprimé'
            ];
         }
}
