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
use AVN\Authorize\Models\PaymentProfile;
use AVN\Authorize\Actions\CreateProfile as CreateProfileAction;
use AVN\Authorize\Messages\CreateProfile;
use AVN\Authorize\Messages\GetProfile;

class ProfileMessagesTest extends TestCase
{
    /** @test **/
    public function transaction_set_profile()
    {
        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $profiles = new PaymentProfile(['customerType' => Customer::INDIVIDUAL, 'payment' => $payment]);
        $profile = (new Profile(['merchantCustomerId' => '12355', 'email' => 'test@test.com', 'description' => 'test', 'paymentProfiles' => $profiles]));
        $message = new CreateProfile(['profile' => $profile, 'validationMode' => Profile::LIVE_MODE]);

        $this->assertEquals('{"profile":{"merchantCustomerId":"12355","description":"test","email":"test@test.com","paymentProfiles":{"customerType":"individual","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}},"validationMode":"liveMode"}', $message->toJson());
    }

    /** @test **/
    public function transaction_get_profile()
    {
        $message = new GetProfile(['customerProfileId' => '12345', 'includeIssuerInfo' => 'true']);
        
        $this->assertEquals('{"customerProfileId":"12345","includeIssuerInfo":"true"}', $message->toJson());
    }

    /** @test **/
    public function transaction_create_profile()
    {
        $card = (new CreditCard(['cardNumber' => '4111111111111111', 'expirationDate' => '2019-12', 'cardCode' => '999']));
        $payment = (new Payment())->setCreditCard($card);
        $profiles = new PaymentProfile(['customerType' => Customer::INDIVIDUAL, 'payment' => $payment]);
        $customer = substr(md5(microtime()), 0, 10);
        $profile = (new Profile(['merchantCustomerId' => $customer, 'email' => 'test@test.com', 'description' => 'test', 'paymentProfiles' => $profiles]));
        $message = new CreateProfile(['profile' => $profile, 'validationMode' => Profile::TEST_MODE]);

        $gateway = new Gateway(getenv('LOGIN_ID'), getenv('TRANS_KEY'), true);

        $action = new CreateProfileAction($message->data());

        $gateway->setAction($action);

        $this->assertEquals('{"createCustomerProfileRequest":{"merchantAuthentication":{"name":"'.getenv('LOGIN_ID').'","transactionKey":"'.getenv('TRANS_KEY').'"},"profile":{"merchantCustomerId":"'.$customer.'","description":"test","email":"test@test.com","paymentProfiles":{"customerType":"individual","payment":{"creditCard":{"cardNumber":"4111111111111111","expirationDate":"2019-12","cardCode":"999"}}}},"validationMode":"testMode"}}', $gateway->json());
    
        $response = $gateway->setAction($action)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->customerProfileId());
        $this->assertEquals('Ok', $response->resultCode());
    }
}