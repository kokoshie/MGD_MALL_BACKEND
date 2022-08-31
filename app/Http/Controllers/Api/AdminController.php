<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\RoleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    //
    public function send_login_data(Request $request)
    {
        // dd(auth()->user());
        $email = $request->email;
        $pass = $request->password;
        $hasUser = User::where('email',$email)->first();
        $checkRole = RoleUser::where('user_id',$hasUser->id)->first();

        if(isset($hasUser))
        {
            if($checkRole->role_id == 1)
            {
                $role = 'Admin';
            }
            else
            {
                $role = 'Editor';
            }
            if(Hash::check($pass, $hasUser->password))
            {
                return response()->json([
                    'user' => $hasUser,
                    'role' => $role,
                    'Token' => $hasUser->createToken(time())->plainTextToken
                ]);
            }
            else
            {
                return response()->json([
                    'user' => null,
                    'role' => $role,
                    'Token' => null
                ]);
            }
        }
        else
        {
            // dd("not");
            return response()->json("not have");
            return response()->json([
                'user' => null,
                'role' => null,
                'Token' => null
            ]);
        }
    }
}
