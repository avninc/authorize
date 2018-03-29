<?php

namespace AVN\Authorize;

use AVN\Authorize\Response;
use GuzzleHttp\Client as HttpClient;
use AVN\Authorize\Messages\Authenticate;
use AVN\Authorize\Actions\AbstractAction;
use AVN\Authorize\Actions\AuthenticateTest;

class Gateway
{
    const API_SANDBOX = 'https://apitest.authorize.net/xml/v1/request.api';
    const API_PRODUCTION = 'https://api.authorize.net/xml/v1/request.api';

    public $client;
    protected $action;
    protected $auth;
    protected $json;
    protected $prettyJson;
    protected $response;
    protected $refId = null;

    protected $requestData = [];

    protected $inTest = false;
    protected $loginId = null;
    protected $transactionKey = null;

    public function __construct($loginId, $transactionKey, $inTest = false)
    {
        $this->setInTest($inTest)
            ->setLoginId($loginId)
            ->setTransactionKey($transactionKey)
            ->setClient()
            ->setAuth();
    }

    public function setAction(AbstractAction $class)
    {
        $this->action = $class->setData($this->getRequestData() + $class->data());
        $this->setJson($this->action->toJson());
        $this->setPrettyJson($this->action->pretty());

        return $this;
    }

    public function send()
    {
        $response = $this->client->request('POST', '', ['body' => $this->json()]);
        
        $this->setResponse(new Response($response));

        return $this->response;
    }

    protected function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    public function json()
    {
        return $this->json;
    }

    protected function setPrettyJson($json)
    {
        $this->prettyJson = $json;

        return $this;
    }

    public function pretty()
    {
        return $this->prettyJson;
    }

    protected function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setAuth()
    {
        $this->auth = new Authenticate(['name' => $this->loginId, 'transactionKey' => $this->transactionKey]);
        $this->requestSet($this->auth->data());

        return $this;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function requestSet(array $data)
    {
        $this->requestData = $data;

        return $this;
    }

    public function requestAppend($key, array $data)
    {
        $this->requestData[$key] = $data;

        return $this;
    }

    public function getRequestData()
    {
        $data = $this->requestData;

        if($this->refId) {
            $data += ['refId' => $this->refId];
        }

        return $data;
    }

    protected function setClient()
    {
        $this->client = new HttpClient([
            'base_uri' => $this->getEndpoint(),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        return $this;
    }

    public function client()
    {
        return $this->client;
    }

    public function setInTest(bool $value)
    {
        $this->inTest = $value;

        return $this;
    }

    public function inTest()
    {
        return $this->inTest;
    }

    public function setLoginId(string $value)
    {
        $this->loginId = $value;

        return $this;
    }

    public function loginId()
    {
        return $this->loginId;
    }

    public function setTransactionKey(string $value)
    {
        $this->transactionKey = $value;

        return $this;
    }

    public function transactionKey()
    {
        return $this->transactionKey;
    }

    public function getEndpoint()
    {
        return $this->inTest ? static::API_SANDBOX : static::API_PRODUCTION;
    }

    /**
     * Get the value of refId
     */ 
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * Set the value of refId
     *
     * @return  self
     */ 
    public function setRefId($refId)
    {
        $this->refId = $refId;

        return $this;
    }
}
