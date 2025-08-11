<?php

namespace App\Constant;

class Content
{
    
    //DOCUMENTATION STATUS
    CONST DOCUMENTATION_STATUS_TRUE = true;
    CONST DOCUMENTATION_STATUS_FALSE = false;
    CONST DOCUMENTATION_STATUS_LIST = [
        self::DOCUMENTATION_STATUS_TRUE => 'Actif',
        self::DOCUMENTATION_STATUS_FALSE => 'Inactif'
    ];

}