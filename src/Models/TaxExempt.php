<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class TaxExempt extends AbstractModel
{
    protected $taxExempt = 'false';

    public function attributeName() : string
    {
        return 'taxExempt';
    }

    public function data()
    {
        $data = $this->data;

        if($this->taxExempt) {
            $data['taxExempt'] = $this->taxExempt;
        }

        return $data;
    }

    /**
     * Get the value of taxExempt
     */ 
    public function getTaxExempt()
    {
        return $this->taxExempt;
    }

    /**
     * Set the value of taxExempt
     *
     * @return  self
     */ 
    public function setTaxExempt($taxExempt)
    {
        $this->taxExempt = $taxExempt;

        return $this;
    }
}