<?php

namespace AVN\Authorize\Contracts;

interface ModelContract 
{
    public function setData(array $data = []);
    
    public function data();

    public function attributeName();

    public function toJson($options=null);
}