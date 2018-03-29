<?php

namespace AVN\Authorize\Contracts;

interface ActionContract 
{
    public function setData(array $data = []);
    
    public function data();

    public function attributeName();

    public function toJson($options=null);
}