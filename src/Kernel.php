<?php

namespace Cadret;

class Kernel
{

    private $router;
    
    public function __construct($router){
        $this->router = $router;
    }

    public function getRouter(){
        return $this->router;
    }
}