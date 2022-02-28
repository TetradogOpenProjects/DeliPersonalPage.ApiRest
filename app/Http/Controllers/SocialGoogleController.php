<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use App\Models\TokenUser;
use App\DTOs\TokenUserDTO;
use App\DTOs\UserDTO;

use Illuminate\Http\Request;

class SocialGoogleController extends Controller
{

    public function Login(Request $request){
  
        $token=$request->input('tokenOwn');
        //guardo el token
        session(['tokenOwn'=>$token]);
        return redirect(Route('loginGoogle'));

    }
 
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
       

    public function genToken()
    {
        try {
            
            if(session()->has('tokenOwn'))
            {
                $googleUser = Socialite::driver('google')->user();
                $user = User::where('email', $googleUser->email)->first();
        
                if(is_null($user)){
        
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'social_id'=> $googleUser->id,
                        'social_type'=> 'google',
                        'avatar'=>$googleUser->avatar,
                        'password' => encrypt('google no password requiered')
                    ]);
        
                }
               TokenUser::GenToken($user,session('tokenOwn'));
               session()->forget('tokenOwn');
               return '<script type="text/javascript">window.close();</script>';

                }else{
                dd('you need tokenOwn param');
            }
     
        } catch (Exception $e) {
            
            dd('Error, no se ha podido hacer login');
        }
   
 
    }
   


}
