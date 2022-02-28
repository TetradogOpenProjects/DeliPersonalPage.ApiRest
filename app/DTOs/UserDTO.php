<?php

namespace App\DTOs;

class UserDTO{
    function __construct($user){
        $this->Name=$user->name;
        $this->Avatar=$user->avatar;
        $this->Email=$user->email;
    }
    public function ToJson(){
        return json_encode($this);
    }
}