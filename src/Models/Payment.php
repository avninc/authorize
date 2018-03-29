<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\TrackData;
use AVN\Authorize\Models\CreditCard;
use AVN\Authorize\Models\AbstractModel;

class Payment extends AbstractModel
{
    protected $trackData = null;
    protected $creditCard = null;

    public function attributeName() : string
    {
        return 'payment';
    }

    public function data()
    {
        $data = $this->data;

        if($this->getCreditCard() != '') {
            $data['creditCard'] = $this->getCreditCard()->data();
        }

        if($this->getTrackData() != '') {
            $data['trackData'] = $this->getTrackData()->data();
        }
        
        return $data;
    }

    /**
     * Get the value of creditCard
     */ 
    public function getCreditCard() : ?CreditCard
    {
        return $this->creditCard;
    }

    /**
     * Set the value of creditCard
     *
     * @return  self
     */ 
    public function setCreditCard(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    /**
     * Get the value of trackData
     */ 
    public function getTrackData() : ?TrackData
    {
        return $this->trackData;
    }

    /**
     * Set the value of trackData
     *
     * @return  self
     */ 
    public function setTrackData(TrackData $trackData)
    {
        $this->trackData = $trackData;

        return $this;
    }
}