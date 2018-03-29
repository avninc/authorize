<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class CreditCard extends AbstractModel
{
    protected $cardNumber = null;
    protected $expirationDate = null;
    protected $cardCode = null;

    public function attributeName() : string
    {
        return 'creditCard';
    }

    public function data()
    {
        $data = $this->data;

        if($this->cardNumber) {
            $data['cardNumber'] = $this->cardNumber;
        }

        if($this->expirationDate) {
            $data['expirationDate'] = $this->expirationDate;
        }

        if($this->cardCode) {
            $data['cardCode'] = $this->cardCode;
        }

        return $data;
    }

    /**
     * Get the value of cardNumber
     */ 
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set the value of cardNumber
     *
     * @return  self
     */ 
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get the value of expirationDate
     */ 
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set the value of expirationDate
     *
     * @return  self
     */ 
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }
}