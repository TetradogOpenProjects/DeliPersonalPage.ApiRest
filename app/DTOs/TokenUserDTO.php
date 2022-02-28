<?php

namespace App\DTOs;

use App\Models\TokenUser;

class TokenUserDTO{
    function __construct($tokenUser){
        $this->Dic=[
            'Token'=>$tokenUser->token,
            'RenovarToken'=>$tokenUser->renovarToken,
            'RenovarTokenLifeInits'=>$tokenUser->created_at->format('d/m/Y h:i:s'),
            'SecondsToRenoveToken'=>TokenUser::RENOVAR_TOKEN_LIFE
        ];
    }

}