<?php

namespace Test\Unit;

use GuzzleHttp\Client;
use AVN\Authorize\Gateway;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{
    /** @test **/
    public function can_create_gateway()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $this->assertEquals($gateway->loginId(), getenv('LOGIN_ID'));
        $this->assertEquals($gateway->transactionKey(), getenv('TRANS_KEY'));
    }

    /** @test **/
    public function gateway_endpoint_correct()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'));

        $this->assertEquals('https://api.authorize.net/xml/v1/request.api', $gateway->getEndPoint());

        $gateway->setInTest(true);

        $this->assertEquals('https://apitest.authorize.net/xml/v1/request.api', $gateway->getEndPoint());
    }

    /** @test **/
    public function gateway_client_exists()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $this->assertInstanceOf(Client::class, $gateway->client);
    }

    /** @test **/
    public function gateway_request_data_not_empty()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $this->assertNotEmpty($gateway->getRequestData());
    }

    /** @test **/
    public function gateway_auth_message_exists_and_accurate()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $this->assertNotEmpty($gateway->auth()->toJson());
        $this->assertEquals('{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"}}', $gateway->auth()->toJson());
    }
}