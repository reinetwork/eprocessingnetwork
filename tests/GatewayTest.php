<?php
use Omnipay\Omnipay;

/**
 * A base test case object where you can put common logic if it is needed.
 */

class BaseTestCase extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->gateway = Omnipay::create('\REINetwork\eProcessingNetwork\Gateway');
        $this->gateway->setApiLoginId('080880');
        $this->gateway->setTransactionKey('yFqqXJh9Pqnugfr');
    }

    public function testGetName()
    {

        $response = $this->gateway->getName();
    }

    /**
     * @dataProvider purchaseDataProvider
     */
    public function testAuthorize($purchaseOptions, $assertion, $expectedException, $expectedMessage)
    {

        //@todo
        $this->markTestIncomplete('Unfinished...');


        $this->setExpectedException($expectedException);

        $response = $this->gateway->authorize($purchaseOptions)->send();

        if ($assertion === true) {
            $this->assertTrue($response->isSuccessful());
        } else {
            $this->assertFalse($response->isSuccessful());
        }

        $this->assertSame($expectedMessage, $response->getMessage());

    }


    /**
     * @dataProvider purchaseDataProvider
     */
    public function testPurchase($purchaseOptions, $assertion, $expectedException, $expectedMessage)
    {

        $this->setExpectedException($expectedException);

        $response = $this->gateway->purchase($purchaseOptions)->send();

        if ($assertion === true) {
            $this->assertTrue($response->isSuccessful());
        } else {
            $this->assertFalse($response->isSuccessful());
        }

        $this->assertSame($expectedMessage, $response->getMessage());

    }


    public function purchaseDataProvider()
    {
        $formData = [
            'firstName' => 'PabloName',
            'lastName' => 'TestLastName',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $purchaseOptionsOk = [
            'amount' => '888.88',
            'currency' => 'USD',
            'card' => $formData
        ];

        $purchaseOptionsFailure = [
            'amount' => '0',
            'currency' => 'USD',
            'card' => $formData
        ];

        return [
            [
                $purchaseOptionsOk,
                true,
                null,
                'This transaction has been approved.'
            ],
            [
                $purchaseOptionsFailure,
                false,
                '\Omnipay\Common\Exception\InvalidRequestException',
                'A valid amount is required.'
            ],
        ];
    }
}
