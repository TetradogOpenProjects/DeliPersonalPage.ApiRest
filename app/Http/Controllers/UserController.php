<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Auth;
use Exception;
use App\Models\User;
use App\Models\TokenUser;
use App\DTOs\TokenUserDTO;
use App\DTOs\UserDTO;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function getToken(Request $request){
     
        $token=TokenUser::GetToken($request->json()->all()['TokenOwn']);
        if(is_null($token)){
            $resp=["Error"=>"TokenOwn incorrecto/obsoleto"];
        }else{
            $resp=(new TokenUserDTO($token))->Dic;
      
            $token->tokenOwn=TokenUser::GenerateToken(TokenUser::LENGTH_TOKENOWN);//así es de un solo uso :)
            $token->save();
        }
        
        $resp = json_encode($resp, JSON_FORCE_OBJECT);
      
        return response()->json($resp);
    }

    public function renovarToken(Request $request){

        $tokenUser=TokenUser::RenovarToken($request->json()->all()['RenovarToken']);
        if(!is_null($tokenUser)){
            $resp=(new TokenUserDTO($tokenUser))->Dic;
        }else{
            $resp=["Error"=>"No se ha podido renovar, vuelve a llamar getToken "];
        }
        return response()->json($resp);
    }
    public function getUserInfo(Request $request){
        return (new UserDTO($this->GetUser($request)))->ToJson();
    }
    private function GetUser(Request $request){
      
        return TokenUser::GetUser($request->json()->all()['Token']);
    }
}
