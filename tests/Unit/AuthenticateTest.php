<?php

namespace Test\Unit;

use AVN\Authorize\Gateway;
use AVN\Authorize\Actions\Authenticate;
use PHPUnit\Framework\TestCase;

class AutenticateTest extends TestCase
{
    /** @test **/
    public function auth_action_json_valid()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);
        $action = new Authenticate();

        $gateway->setAction($action);

        $this->assertEquals('{"authenticateTestRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"}}}', $gateway->json());
    }

    /** @test **/
    public function auth_action_request_successful()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);
        $action = new Authenticate();

        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
    }

    /** @test **/
    public function auth_action_request_messages_exists()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);
        $action = new Authenticate();

        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->messages());
        $this->assertEquals('I00001', $response->message()['code']);
        $this->assertEquals('I00001', $response->messageCode());
        $this->assertEquals('Successful.', $response->messageText());
    }

    /** @test **/
    public function gateway_refid_exists_in_json_request()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);
        $action = new Authenticate();
        $gateway->setRefId(123);
        $gateway->setAction($action);

        $this->assertNotEmpty($gateway->json());
        $this->assertEquals('{"authenticateTestRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"refId":123}}', $gateway->json());
    }

    /** @test **/
    public function gateway_refid_exists_in_response()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);
        $action = new Authenticate();
        $gateway->setRefId(123);

        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(123, $response->refId());
    }
}