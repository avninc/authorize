<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\BillTo;
use AVN\Authorize\Models\Payment;
use AVN\Authorize\Models\AbstractModel;

class PaymentProfile extends AbstractModel
{
    protected $customerPaymentProfileId = null;
    protected $paymentProfileId = null;
    protected $customerType = null;
    protected $billTo = null;
    protected $payment = null;

    public function attributeName() : string
    {
        return $this->getPaymentProfileId() ? 'paymentProfile' : 'paymentProfiles';
    }

    public function data()
    {
        $data = $this->data;

        $fields = ['customerPaymentProfileId', 'paymentProfileId', 'customerType', 'billTo', 'payment'];
        
        foreach($fields as $key) {
            if($this->{$key} !== null) {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
    }

    /**
     * Get the value of customerType
     */ 
    public function getCustomerType() : string
    {
        return $this->customerType;
    }

    /**
     * Set the value of customerType
     *
     * @return  self
     */ 
    public function setCustomerType($customerType)
    {
        $this->customerType = $customerType;
        $this->data['customerType'] = $customerType;

        return $this;
    }

    /**
     * Get the value of billTo
     */ 
    public function getBillTo() : BillTo
    {
        return $this->billTo;
    }

    /**
     * Set the value of billTo
     *
     * @return  self
     */ 
    public function setBillTo(BillTo $billTo)
    {
        $this->billTo = $billTo->data();
        $this->data['billTo'] = $billTo->data();

        return $this;
    }

    /**
     * Get the value of payment
     */ 
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set the value of payment
     *
     * @return  self
     */ 
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment->data();
        $this->data['payment'] = $payment->data();

        return $this;
    }

    /**
     * Get the value of customerPaymentProfileId
     */ 
    public function getCustomerPaymentProfileId()
    {
        return $this->customerPaymentProfileId;
    }

    /**
     * Set the value of customerPaymentProfileId
     *
     * @return  self
     */ 
    public function setCustomerPaymentProfileId($customerPaymentProfileId)
    {
        $this->customerPaymentProfileId = $customerPaymentProfileId;
        $this->data['customerPaymentProfileId'] = $customerPaymentProfileId;

        return $this;
    }

    /**
     * Get the value of paymentProfileId
     */ 
    public function getPaymentProfileId()
    {
        return $this->paymentProfileId;
    }

    /**
     * Set the value of paymentProfileId
     *
     * @return  self
     */ 
    public function setPaymentProfileId($paymentProfileId)
    {
        $this->paymentProfileId = $paymentProfileId;
        $this->data['paymentProfileId'] = $paymentProfileId;

        return $this;
    }
}