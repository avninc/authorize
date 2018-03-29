<?php

namespace Test\Unit;

use AVN\Authorize\Gateway;
use AVN\Authorize\Models\Tax;
use AVN\Authorize\Models\Duty;
use PHPUnit\Framework\TestCase;
use AVN\Authorize\Models\Payment;
use AVN\Authorize\Models\Profile;
use AVN\Authorize\Models\Shipping;
use AVN\Authorize\Models\LineItem;
use AVN\Authorize\Models\Customer;
use AVN\Authorize\Models\LineItems;
use AVN\Authorize\Models\BillTo;
use AVN\Authorize\Models\ShipTo;
use AVN\Authorize\Models\CreditCard;
use AVN\Authorize\Actions\Transaction;
use AVN\Authorize\Models\PaymentProfile;
use AVN\Authorize\Messages\Transaction as TransactionMessage;

class TransactionMessagesTest extends TestCase
{
    /** @test **/
    public function transaction_set_trans_type()
    {
        $message = new TransactionMessage();
        $message->setPayment(new Payment());

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","payment":[]}}', $message->toJson());

        $message->setAmount('10.12')->setTransactionType(TransactionMessage::AUTH_ONLY)->setPayment(new Payment());

        $this->assertEquals('{"transactionRequest":{"transactionType":"authOnlyTransaction","amount":"10.12","payment":[]}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_amount()
    {
        $message = new TransactionMessage(['amount' => '10.11']);
        $message->setPayment(new Payment());

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":[]}}', $message->toJson());

        $message->setAmount('123.11')->setTransactionType(TransactionMessage::AUTH_ONLY);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authOnlyTransaction","amount":"123.11","payment":[]}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_payment()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $message->setPayment($payment);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}}', $message->toJson());

        $card->setCardNumber('4111111111111112');
        $payment->setCreditCard($card);
        $message->setPayment($payment);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111112","expirationDate":"2019-12","cardCode":"999"}}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_lineitems()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $item = new LineItem(['itemId' => 1, 'name' => 'vase', 'description' => 'test', 'quantity' => 1, 'unitPrice' => '4.00']);

        $items = (new LineItems())->addItem($item);

        $message->setPayment($payment);
        $message->setLineItems($items);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"lineItems":[{"lineItem":{"itemId":1,"name":"vase","description":"test","quantity":1,"unitPrice":"4.00"}}]}}', $message->toJson());


        $rows = [
            ['itemId' => 1, 'name' => 'vase', 'description' => 'test', 'quantity' => 1, 'unitPrice' => '4.00'],
            ['itemId' => 2, 'name' => 'vase', 'description' => 'test', 'quantity' => 2, 'unitPrice' => '4.00'],
            ['itemId' => 3, 'name' => 'vase', 'description' => 'test', 'quantity' => 1, 'unitPrice' => '4.00']
        ];

        $items = (new LineItems())->setItems($rows);

        $message->setPayment($payment);
        $message->setLineItems($items);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"lineItems":[{"itemId":1,"name":"vase","description":"test","quantity":1,"unitPrice":"4.00"},{"itemId":2,"name":"vase","description":"test","quantity":2,"unitPrice":"4.00"},{"itemId":3,"name":"vase","description":"test","quantity":1,"unitPrice":"4.00"}]}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_tax()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $tax = new Tax(['amount' => '4.22', 'name' => 'level2 tax', 'description' => 'tax']);

        $message->setPayment($payment);
        $message->setTax($tax);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"tax":{"name":"level2 tax","description":"tax","amount":"4.22"}}}', $message->toJson());

        $tax = new Tax(['amount' => '4.55', 'name' => 'level 3 tax', 'description' => 'tax']);
        $message->setTax($tax);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"tax":{"name":"level 3 tax","description":"tax","amount":"4.55"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_duty()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $duty = new Duty(['amount' => '4.22', 'name' => 'level 2 duty', 'description' => 'duty']);

        $message->setPayment($payment);
        $message->setDuty($duty);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"duty":{"name":"level 2 duty","description":"duty","amount":"4.22"}}}', $message->toJson());

        $duty = new Duty(['amount' => '4.55', 'name' => 'level 3 duty', 'description' => 'duty']);
        $message->setDuty($duty);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"duty":{"name":"level 3 duty","description":"duty","amount":"4.55"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_shipping()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $message->setPayment($payment)->setShipping(new Shipping(['amount' => '4.22', 'name' => 'level 2 shipping', 'description' => 'shipping']));

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"shipping":{"name":"level 2 shipping","description":"shipping","amount":"4.22"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_ponumber()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $message->setPayment($payment)->setPoNumber('123');

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"poNumber":"123"}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_customer()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $message->setPayment($payment)->setCustomer(new Customer(['id' => 123, 'type' => Customer::INDIVIDUAL]));

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"customer":{"id":123,"type":"individual"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_billto()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $info = new BillTo([
            'firstName' => 'Vincent',
            'lastName' => 'Gabriel',
            'company' => 'AVN'
        ]);
        $message->setPayment($payment)->setBillTo($info);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"billTo":{"firstName":"Vincent","lastName":"Gabriel","company":"AVN"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_shipto()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $info = new ShipTo([
            'firstName' => 'Vincent',
            'lastName' => 'Gabriel',
            'company' => 'AVN'
        ]);
        $message->setPayment($payment)->setShipTo($info);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"shipTo":{"firstName":"Vincent","lastName":"Gabriel","company":"AVN"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_billto_and_shipto()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $bill = new BillTo([
            'firstName' => 'Vincent',
            'lastName' => 'Gabriel',
            'company' => 'AVN'
        ]);

        $ship = new ShipTo([
            'firstName' => 'Vincent',
            'lastName' => 'Gabriel',
            'company' => 'AVN'
        ]);

        $message->setPayment($payment)->setBillTo($bill)->setShipTo($ship);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"billTo":{"firstName":"Vincent","lastName":"Gabriel","company":"AVN"},"shipTo":{"firstName":"Vincent","lastName":"Gabriel","company":"AVN"}}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_customer_ip()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);

        $message->setPayment($payment)->setCustomerIp('127.0.0.1');

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}},"customerIp":"127.0.0.1"}}', $message->toJson());
    }

    /** @test **/
    public function transaction_set_trans_customer_profile()
    {
        $message = new TransactionMessage(['amount' => '10.11']);

        $paymentProfile = new PaymentProfile(['paymentProfileId' => '27388924']);
        $profile = new Profile(['customerProfileId' => '25000332', 'paymentProfile' => $paymentProfile]);
        $message->setProfile($profile);

        $this->assertEquals('{"transactionRequest":{"transactionType":"authCaptureTransaction","amount":"10.11","profile":{"customerProfileId":"25000332","paymentProfile":{"paymentProfileId":"27388924"}}}}', $message->toJson());
    }
}