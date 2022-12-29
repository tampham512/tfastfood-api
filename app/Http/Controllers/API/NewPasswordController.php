<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required']);

        $status = Password::sendResetLink($request->only('email') );
        if( $status === Password::RESET_LINK_SENT ){
            return [
                'status' =>__($status),
            
            ];
        }
        else{
            return [
                'status' =>__($status),
                'mail' => $request->only('email')
            ];
        }
     
      
        
    }
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
  
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user)  use ($request){
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
                event(new PasswordReset($user));
            }
        );
    
        if ($status === Password::PASSWORD_RESET)
        {
            return [
                'status' =>200,
                'message'=>"Đặt Lại Mật Khẩu Thành Công!"
            
            ];
        }

        return [
            'message'=>__($status)
        ];
               
    }
}