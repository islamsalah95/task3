<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiTraits;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function Login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return  response()->json(['message'=>'wrong password'], 400);
            }

            $tokens = $user->createToken('Android')->plainTextToken;
            $user->token = 'Bearer ' . $tokens;
           
            return  response()->json(['data'=>$user,'message'=>'you login success'], 200);


        } else{
            return  response()->json(['message'=>'you are not register before'], 400);
        }
        
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $user =  User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $tokens = $user->createToken('Android')->plainTextToken;
        $user->token = 'Bearer ' . $tokens;

        return  response()->json(['data'=>$user,'message'=>'you register success'], 200);

        
    }

}
