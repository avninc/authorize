<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class PoNumber extends AbstractModel
{
    protected $poNumber = 'false';

    public function attributeName() : string
    {
        return 'poNumber';
    }

    public function data()
    {
        return $this->poNumber;
    }

    /**
     * Get the value of poNumber
     */ 
    public function getPoNumber()
    {
        return $this->poNumber;
    }

    /**
     * Set the value of poNumber
     *
     * @return  self
     */ 
    public function setPoNumber($poNumber)
    {
        $this->poNumber = $poNumber;

        return $this;
    }
}