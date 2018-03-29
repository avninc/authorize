<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Models\Tax;
use AVN\Authorize\Models\Duty;
use AVN\Authorize\Models\BillTo;
use AVN\Authorize\Models\ShipTo;
use AVN\Authorize\Models\Shipping;
use AVN\Authorize\Models\Payment;
use AVN\Authorize\Models\Profile;
use AVN\Authorize\Models\Order;
use AVN\Authorize\Models\Customer;
use AVN\Authorize\Models\LineItems;
use AVN\Authorize\Contracts\MessageContract;

abstract class AbstractMessage implements MessageContract
{
    const CAPTURE = 'authCaptureTransaction';
    const AUTH_ONLY = 'authOnlyTransaction';
    const COMPLETE_AUTH = 'priorAuthCaptureTransaction';
    const REFUND = 'refundTransaction';
    const VOID = 'voidTransaction';
    
    protected $data = [];

    protected $transactionType = null;
    protected $amount = null;
    protected $payment = null;
    protected $profile = null;
    protected $order = null;
    protected $lineItems = null;
    protected $tax = null;
    protected $duty = null;
    protected $shipping = null;
    protected $poNumber = null;
    protected $customer = null;
    protected $billTo = null;
    protected $shipTo = null;
    protected $customerIp = null;
    protected $userFields = null;
    protected $refTransId = null;

    protected static $fieldsSort = [
        'name' => -2,
        'transactionKey' => 1,

        'transactionType' => 0,
        'amount' => 1,
        'payment' => 2,
        'lineItems' => 3,
        'tax' => 4,
        'duty' => 5,
        'shipping' => 6,
        'poNumber' => 7,
        'profile' => 8,
        'order' => 9,
        'customer' => 10,
        'billTo' => 11,
        'shipTo' => 12,
        'customerIP' => 13,
        'userFields' => 14,
        'refTransId' => 15,

        'merchantCustomerId' => -3,
        'description' => -1,
        'email' => 1,
        'paymentProfiles' => 2,

        'customerType' => 0,

        'cardNumber' => 0,
        'expirationDate' => 1,
        'cardCode' => 2,

        'itemId' => -3,
        'quantity' => 20,
        'unitPrice' => 21,

        'type' => -3,
        'id' => -2,

        'invoiceNumber' => -2,

    ];

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function toJson($options=null)
    {
        return json_encode($this->data(), $options);
    }

    public function pretty()
    {
        return "\n\n". $this->toJson(JSON_PRETTY_PRINT) ."\n\n";
    }

    public function setData(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function data()
    {
        if($this->attributeName() == '') {
            return $this->sortedData();
        }
        return [$this->attributeName() => $this->sortedData()];
    }

    protected function sortedData()
    {
        $data = $this->data;

        $this->recursiveSort($data);

        return $data;
    }

    function recursiveSort(&$array) {
        
        foreach ($array as &$value) {
           if (is_array($value)) {
               $this->recursiveSort($value);
           }
        }

        uksort($array, function($a, $b) {
            $first = static::$fieldsSort[$a] ?? 99;
            $second = static::$fieldsSort[$b] ?? 99;
            return $first > $second;
        });

        return $array;
     }

    /**
     * Get the value of transactionType
     */ 
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set the value of transactionType
     *
     * @return  self
     */ 
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        $this->data['transactionType'] = $transactionType;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return (string) $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;
        $this->data['amount'] = $amount;

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
     * Get the value of lineItems
     */ 
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * Set the value of lineItems
     *
     * @return  self
     */ 
    public function setLineItems(LineItems $lineItems)
    {
        $this->lineItems = $lineItems->data();
        $this->data['lineItems'] = $lineItems->data();

        return $this;
    }

    /**
     * Get the value of tax
     */ 
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set the value of tax
     *
     * @return  self
     */ 
    public function setTax(Tax $tax)
    {
        $this->tax = $tax->data();
        $this->data['tax'] = $tax->data();

        return $this;
    }

    /**
     * Get the value of duty
     */ 
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * Set the value of duty
     *
     * @return  self
     */ 
    public function setDuty(Duty $duty)
    {
        $this->duty = $duty->data();
        $this->data['duty'] = $duty->data();

        return $this;
    }

    /**
     * Get the value of shipping
     */ 
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set the value of shipping
     *
     * @return  self
     */ 
    public function setShipping(Shipping $shipping)
    {
        $this->shipping = $shipping->data();
        $this->data['shipping'] = $shipping->data();

        return $this;
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
        $this->data['poNumber'] = $poNumber;

        return $this;
    }

    /**
     * Get the value of customer
     */ 
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     *
     * @return  self
     */ 
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer->data();
        $this->data['customer'] = $customer->data();

        return $this;
    }

    /**
     * Get the value of billTo
     */ 
    public function getBillTo()
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
     * Get the value of shipTo
     */ 
    public function getShipTo()
    {
        return $this->shipTo;
    }

    /**
     * Set the value of shipTo
     *
     * @return  self
     */ 
    public function setShipTo(ShipTo $shipTo)
    {
        $this->shipTo = $shipTo->data();
        $this->data['shipTo'] = $shipTo->data();

        return $this;
    }

    /**
     * Get the value of customerIp
     */ 
    public function getCustomerIp()
    {
        return $this->customerIp;
    }

    /**
     * Set the value of customerIp
     *
     * @return  self
     */ 
    public function setCustomerIp($customerIp)
    {
        $this->customerIp = $customerIp;
        $this->data['customerIp'] = $customerIp;

        return $this;
    }

    /**
     * Get the value of userFields
     */ 
    public function getUserFields()
    {
        return $this->userFields;
    }

    /**
     * Set the value of userFields
     *
     * @return  self
     */ 
    public function setUserFields($userFields)
    {
        $this->userFields = $userFields;
        $this->data['userFields'] = $userFields;

        return $this;
    }

    /**
     * Get the value of refTransId
     */ 
    public function getRefTransId()
    {
        return $this->refTransId;
    }

    /**
     * Set the value of refTransId
     *
     * @return  self
     */ 
    public function setRefTransId($refTransId)
    {
        $this->refTransId = $refTransId;
        $this->data['refTransId'] = $refTransId;

        return $this;
    }

    /**
     * Get the value of profile
     */ 
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set the value of profile
     *
     * @return  self
     */ 
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile->data();
        $this->data['profile'] = $profile->data();

        return $this;
    }

    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    public function setOrder(Order $order)
    {
        $this->order = $order->data();
        $this->data['order'] = $order->data();

        return $this;
    }
}