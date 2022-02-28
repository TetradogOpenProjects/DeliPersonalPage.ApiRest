<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class TokenUser extends Model
{
    use HasFactory;
    const LENGTH=120;

    const TOKEN_LIFE=60*60;
    const RENOVAR_TOKEN_LIFE=3*24*60*60;
    const LENGTH_TOKENOWN=90;

    protected $table="TokenUsers";

    public function TokenStillAlive(){
        return $this->IsValid($this->updated_at, self::TOKEN_LIFE);
    }
    public function RenovarTokenStillAlive(){
        return $this->IsValid($this->created_at, self::RENOVAR_TOKEN_LIFE);
    }
    private function IsValid($fecha,$segundosVida){
        $date=new DateTime();

        $resta=$date->diff(new DateTime($fecha));

        return ((($dateInterval->d * 24) + $dateInterval->h)*3600 + //horas
                   $dateInterval->i *60 + //minutos
                   $dateInterval->s) < $segundosVida;
    }
    public function User(){
        return $this->hasOne(User::class);
    }
    public static function GenerateToken($length=self::LENGTH){
        return Str::random($length);
    }
    public static function GetToken($tokenOwn){
        $tokenUser= TokenUser::where('tokenOwn',$tokenOwn)->first();
        return $tokenUser;
    }
    public static function GetUser($token){
        $tokenUser= TokenUser::where('token',$token)->first();
        $user=null;
        if(!is_null($tokenUser) and $tokenUser->TokenStillAlive()){
            $user=$tokenUser->User;
        }
        return $user;
    }
    public static function GenToken($user,$tokenOwn){

        $tokenUser=TokenUser::where('user_id',$user->id)->first();
        if(!is_null($tokenUser))
        {
            $tokenUser->delete();
        }
     
        $tokenUser=new TokenUser();
        $tokenUser->user_id=$user->id;
        $tokenUser->token=self::GenerateToken();
        $tokenUser->renovarToken=self::GenerateToken();
        $tokenUser->tokenOwn=$tokenOwn;
        $tokenUser->save();
    }
    public static function RenovarToken($renovarToken){
       $tokenUser= TokenUser::where('renovarToken',$renovarToken)->first();

       if(!is_null($tokenUser)){
        if($tokenUser->RenovarTokenStillAlive()){
            $tokenUser->token=self::GenerateToken();
            $tokenUser->save();
        }else{
            $tokenUser->delete();
            $tokenUser=null;
        }

       }

       return $tokenUser;
     

    }
}
