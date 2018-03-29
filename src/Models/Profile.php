<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\PaymentProfile;
use AVN\Authorize\Models\AbstractModel;

class Profile extends AbstractModel
{
    const LIVE_MODE = 'liveMode';
    const TEST_MODE = 'testMode';

    protected $merchantCustomerId = null;
    protected $customerProfileId = null;
    protected $description = null;
    protected $email = null;
    protected $paymentProfile = null;
    protected $paymentProfiles = null;

    public function attributeName() : string
    {
        return 'profile';
    }

    public function data()
    {
        $data = $this->data;

        $fields = ['merchantCustomerId', 'customerProfileId', 'description', 'email', 'paymentProfile', 'paymentProfiles'];

        foreach($fields as $key) {
            if($this->{$key} !== null) {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
    }

    /**
     * Get the value of merchantCustomerId
     */ 
    public function getMerchantCustomerId()
    {
        return $this->merchantCustomerId;
    }

    /**
     * Set the value of merchantCustomerId
     *
     * @return  self
     */ 
    public function setMerchantCustomerId($merchantCustomerId)
    {
        $this->merchantCustomerId = $merchantCustomerId;
        $this->data['merchantCustomerId'] = $merchantCustomerId;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;
        $this->data['description'] = $description;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;
        $this->data['email'] = $email;

        return $this;
    }

    /**
     * Get the value of paymentProfiles
     */ 
    public function getPaymentProfiles()
    {
        return $this->paymentProfiles;
    }

    /**
     * Set the value of paymentProfiles
     *
     * @return  self
     */ 
    public function setPaymentProfiles(PaymentProfile $paymentProfiles)
    {
        $this->paymentProfiles = $paymentProfiles->data();
        $this->data['paymentProfiles'] = $paymentProfiles->data();

        return $this;
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
     * Get the value of paymentProfile
     */ 
    public function getPaymentProfile()
    {
        return $this->paymentProfile;
    }

    /**
     * Set the value of paymentProfile
     *
     * @return  self
     */ 
    public function setPaymentProfile(PaymentProfile $paymentProfile)
    {
        $this->paymentProfile = $paymentProfile->data();
        $this->data['paymentProfile'] = $paymentProfile->data();

        return $this;
    }
}