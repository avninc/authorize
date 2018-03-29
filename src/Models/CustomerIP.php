<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class CustomerIP extends AbstractModel
{
    protected $customerIP = null;

    public function attributeName() : string
    {
        return 'customerIP';
    }

    public function data()
    {
        $data = $this->data;

        if($this->customerIP) {
            $data['customerIP'] = $this->customerIP;
        }

        return $data;
    }

    /**
     * Get the value of customerIP
     */ 
    public function getCustomerIP()
    {
        return $this->customerIP;
    }

    /**
     * Set the value of customerIP
     *
     * @return  self
     */ 
    public function setCustomerIP($customerIP)
    {
        $this->customerIP = $customerIP;

        return $this;
    }
}