<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;

//mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'email'=> 'required|email',
            'password' => 'required'
        ]);
 
        if($validator->fails())
        {
            return response()->json([
                //'status_code'=>400,
                'message'=>'uncompleted_credentials'
            ]);
        }

        //-------------------------------------------------

       if (User::where('email', $request->email)->first()) {
            // It exists
            return response()->json([
                //'status_code'=>200,
                'message'=> 'user_exists'
            ]);
       } else {
            $user = new User();            
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();            
    
            return response()->json([
                //'status_code'=>200,
                'message'=> 'user_created'
            ]);
       }     
    }

    //------------------------------------------------

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
           return response()->json([
               //'status_code'=>400, 
               'message'=>'uncompleted_credentials'
           ]);
        }

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                //'status_code'=> 401,
                'message' => 'unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->first();        
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            //'status_code'=> 200,
            'message' => 'authorized',
            'userId' => $user->id,
            'token' => $tokenResult
        ]);
    }

    //------------------------------------------------

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            //'status_code'=> 200,
            'message' => 'token_deleted'
        ]);
    }

    //-------------------------------------------------

    public function users(Request $request)
    {
        try {
            $users = DB::select('select id, name, email from users');

            return response()->json([
                'status_code'=> 200,
                'data' => $users
            ]);
        }
        catch (Exception $e) {
            //throw new Exception('Деление на ноль.');
            return response()->json([
                'status_code'=> 500,
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    //---------------------------------------------------

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['token' => $user->createToken($user->name)->plainTextToken]);
    }

    //---------------------------------------------------

    public function outputConcole()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $uuid = (string) Str::uuid();
        $out->writeln("uuid= ". $uuid);

        Database::createGpsDataTable($uuid);
    }
}
