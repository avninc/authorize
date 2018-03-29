<?php

namespace AVN\Authorize;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use AVN\Authorize\Exceptions\InvalidResponseException;

class Response
{
    protected $response;
    protected $data = [];

    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
        $this->data = $this->jsonDecode();
    }

    protected function jsonDecode()
    {
        $body = (string) $this->response->getBody();
        $body = preg_replace('/[[:^print:]]/', "", $body);
        $body = json_decode($body, true);

        if(!$body || empty($body)) {
            throw new InvalidResponseException(sprintf("Invalid Response from Authorize.net. No body was returned or json data could not be decoded."));
        }

        return $body;
    }

    public function isSuccessful()
    {
        return $this->response->getStatusCode() == 200 && $this->resultCode() == 'Ok';
    }

    public function resultCode()
    {
        return data_get($this->data, 'messages.resultCode');
    }

    public function isFailed()
    {
        return !$this->isSuccessful();
    }

    public function messages()
    {
        return data_get($this->data, 'messages.message');
    }

    public function transaction()
    {
        return data_get($this->data, 'transactionResponse');
    }

    public function profileResponse()
    {
        $response = data_get($this->data, 'profileResponse');
        if($response) {
            return new GuzzleResponse(200, ['Content-Type' => 'application/json'], json_encode($response));
        }
        
        return null;
    }

    public function responseCode()
    {
        return data_get($this->transaction(), 'responseCode');
    }

    public function authCode()
    {
        return data_get($this->transaction(), 'authCode');
    }

    public function avsResultCode()
    {
        return data_get($this->transaction(), 'avsResultCode');
    }

    public function cvvResultCode()
    {
        return data_get($this->transaction(), 'cvvResultCode');
    }

    public function cavvResultCode()
    {
        return data_get($this->transaction(), 'cavvResultCode');
    }

    public function transId()
    {
        return data_get($this->transaction(), 'transId');
    }

    public function refTransID()
    {
        return data_get($this->transaction(), 'refTransID');
    }

    public function transHash()
    {
        return data_get($this->transaction(), 'transHash');
    }

    public function testRequest()
    {
        return data_get($this->transaction(), 'testRequest');
    }

    public function accountNumber()
    {
        return data_get($this->transaction(), 'accountNumber');
    }

    public function accountType()
    {
        return data_get($this->transaction(), 'accountType');
    }

    public function transHashSha2()
    {
        return data_get($this->transaction(), 'transHashSha2');
    }

    public function customerProfileId()
    {
        return data_get($this->data, 'customerProfileId');
    }

    public function customerPaymentProfileIdList()
    {
        return data_get($this->data, 'customerPaymentProfileIdList');
    }

    public function customerPaymentProfileId()
    {
        return data_get($this->customerPaymentProfileIdList(), '0');
    }

    public function customerShippingAddressIdList()
    {
        return data_get($this->data, 'customerShippingAddressIdList');
    }

    public function customerShippingAddressId()
    {
        return data_get($this->customerShippingAddressIdList(), '0');
    }

    public function transactionMessages()
    {
        return data_get($this->transaction(), 'messages');
    }

    public function transactionMessage()
    {
        return data_get($this->transaction(), 'messages.0');
    }

    public function transactionMessageCode()
    {
        return data_get($this->transactionMessage(), 'code');
    }

    public function transactionMessageDescription()
    {
        return data_get($this->transactionMessage(), 'description');
    }

    public function message()
    {
        return data_get($this->data, 'messages.message.0');
    }

    public function refId()
    {
        return data_get($this->data, 'refId');
    }

    public function messageCode()
    {
        return data_get($this->message(), 'code');
    }

    public function messageText()
    {
        return data_get($this->message(), 'text');
    }

    /**
     * Get the value of response
     */ 
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the value of response
     *
     * @return  self
     */ 
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}