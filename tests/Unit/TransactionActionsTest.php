<?php

namespace Test\Unit;

use AVN\Authorize\Gateway;
use PHPUnit\Framework\TestCase;
use AVN\Authorize\Models\Payment;
use AVN\Authorize\Messages\Refund;
use AVN\Authorize\Messages\Capture;
use AVN\Authorize\Messages\AuthOnly;
use AVN\Authorize\Models\CreditCard;
use AVN\Authorize\Actions\Transaction;
use AVN\Authorize\Messages\CompleteAuth;
use AVN\Authorize\Messages\VoidTransaction;
use AVN\Authorize\Messages\Transaction as TransactionMessage;

class TransactionActionsTest extends TestCase
{
    /** @test **/
    public function auth_action_auth_only()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $amount = rand(1,100) . '.00';
        $message = (new AuthOnly(['amount' => $amount]))->setPayment($payment);

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"authOnlyTransaction","amount":"'.$amount.'","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());
    }

    /** @test **/
    public function auth_action_capture()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $amount = rand(1,100) . '.00';
        $message = (new Capture(['amount' => $amount]))->setPayment($payment);

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"'.$amount.'","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());
    }

    /** @test **/
    public function auth_action_auth_complete()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $amount = rand(1,100) . '.00';
        $message = (new AuthOnly(['amount' => $amount]))->setPayment($payment);

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"authOnlyTransaction","amount":"'.$amount.'","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());

        /** Complete */

        $message = (new CompleteAuth(['amount' => $amount]))->setRefTransId($response->transId());

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"priorAuthCaptureTransaction","amount":"'.$amount.'","refTransId":"'.$response->transId().'"}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());
    }

    /** @test **/
    public function auth_action_void()
    {
        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $amount = rand(1,100) . '.00';
        $message = (new Capture(['amount' => $amount]))->setPayment($payment);

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"'.$amount.'","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());

        /** Void */

        $message = (new VoidTransaction())->setRefTransId($response->transId());

        $action = new Transaction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createTransactionRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"transactionRequest":{"transactionType":"voidTransaction","refTransId":"'.$response->transId().'"}}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->transId());
        $this->assertEquals(1, $response->transactionMessageCode());
    }
}