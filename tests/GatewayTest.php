<?php
use Omnipay\Omnipay;
use Omnipay\Tests\GatewayTestCase;

/**
 * eProcessingNetwork Gateway test.
 */
class GatewayCase extends GatewayTestCase
{

    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new \Omnipay\eProcessingNetwork\Gateway($this->getHttpClient(), $this->getHttpRequest());

        //nipay::create('\Omnipay\eProcessingNetwork\Gateway');
        $this->gateway->setApiLoginId('080880');
        $this->gateway->setApiRestrictKey('yFqqXJh9Pqnugfr');
        $this->gateway->setDeveloperMode(false);
    }

    public function testGetName()
    {
        $this->assertSame('eProcessing Network', $this->gateway->getName());
    }

    public function testAuthorize()
    {
        $cardData = [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $request = $this->gateway->authorize(array('amount' => '10.00', 'card' => $cardData));

        $this->assertInstanceOf('Omnipay\eProcessingNetwork\Message\AuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }


    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\eProcessingNetwork\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testChargeStoredCard()
    {
        $request = $this->gateway->chargeStoredCard(array(
            'amount' => '10.00',
            'transactionId' => '123456789-1234',
            'firstName' => 'FIRST_NAME',
            'lastName' => 'LAST_NAME',
            'billingAddress1' => 'BILLING_ADDRESS_1',
            'billingAddress2' => 'BILLING_ADDRESS_2',
            'billingCity' => 'BILLING_CITY',
            'billingState' => 'BILLING_STATE',
            'billingPostcode' => 'BILLING_ZIP',
            'phone' => 'PHONE_NUMBER',
            'description' => 'DESCRIPTION',
        ));

        $this->assertInstanceOf('Omnipay\eProcessingNetwork\Message\ChargeStoredCardRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }


    public function testRemoveAuthorizedTransaction()
    {
        $request = $this->gateway->removeAuthorizedTransaction(array('transactionId' => '1234-5678'));

        $this->assertInstanceOf('Omnipay\eProcessingNetwork\Message\RemoveAuthorizedRequest', $request);
        $this->assertSame('1234-5678', $request->getTransactionId());
    }
}
