<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Models\Profile as ProfileModel;
use AVN\Authorize\Messages\AbstractMessage;

class GetProfile extends AbstractMessage
{
    protected $customerProfileId = null;
    protected $includeIssuerInfo = null;

    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $method = 'set' . ucwords($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        $this->setData($this->data);
    }

    public function data()
    {
        return $this->data;
    }

    public function attributeName() : string
    {
        return '';
    }

    /**
     * Get the value of customerProfileId
     */ 
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * Set the value of customerProfileId
     *
     * @return  self
     */ 
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
        $this->data['customerProfileId'] = $customerProfileId;

        return $this;
    }

    /**
     * Get the value of includeIssuerInfo
     */ 
    public function getIncludeIssuerInfo()
    {
        return $this->includeIssuerInfo;
    }

    /**
     * Set the value of includeIssuerInfo
     *
     * @return  self
     */ 
    public function setIncludeIssuerInfo($includeIssuerInfo)
    {
        $this->includeIssuerInfo = $includeIssuerInfo;
        $this->data['includeIssuerInfo'] = $includeIssuerInfo;

        return $this;
    }
}
