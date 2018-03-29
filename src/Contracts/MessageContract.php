<?php

namespace AVN\Authorize\Contracts;

interface MessageContract 
{
    public function setData(array $data = []);
    
    public function data();

    public function attributeName();

    public function toJson();
}