<?php
use Omnipay\Omnipay;

/**
 * A base test case object where you can put common logic if it is needed.
 */

class GatewayCase extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->gateway = Omnipay::create('\REINetwork\eProcessingNetwork\Gateway');
        $this->gateway->setApiLoginId('080880');
        $this->gateway->setTransactionKey('yFqqXJh9Pqnugfr');
        $this->gateway->setDeveloperMode(false);
    }

    public function testGetName()
    {

        $this->assertSame('eProcessing Network', $this->gateway->getName());
    }

    public function testGetDefaultParameters()
    {
        $this->assertSame([
            'apiLoginId' => '',
            'transactionKey' => '',
            'testMode' => false,
            'developerMode' => false,
        ], $this->gateway->getDefaultParameters());
    }

    public function testGetApiLoginId()
    {
        $this->assertSame('080880', $this->gateway->getApiLoginId());
    }

    public function testGetTransactionKey()
    {
        $this->assertSame('yFqqXJh9Pqnugfr', $this->gateway->getTransactionKey());
    }

    public function testGetDeveloperMode()
    {
        $this->assertFalse($this->gateway->getDeveloperMode());
    }

    /**
     * @dataProvider purchaseDataProvider
     */
    public function testAuthorize($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->authorize($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expected['getCVV2Response'], $response->getCVV2Response());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }


    /**
     * @dataProvider purchaseDataProvider
     */
    public function testPurchase($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->purchase($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expected['getCVV2Response'], $response->getCVV2Response());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }

    /**
     * @dataProvider captureDataProvider
     */
    public function testCapture($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->capture($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }

    /**
     * @dataProvider captureDataProvider
     */
    public function testVoid($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->void($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }


    /**
     * @dataProvider refundDataProvider
     */
    public function testRefund($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->refund($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }

    /**
     * @dataProvider createCardDataProvider
     */
    public function testCreateCard($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->createCard($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }


    /**
     * @dataProvider chargeStoredCardDataProvider
     */
    public function testChargeStoredCard($transactionOptions, $expected)
    {
        $this->setExpectedException($expected['expectedException']);

        $response = $this->gateway->chargeStoredCard($transactionOptions)->send();

        $this->assertSame($expected['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expected['getCode'], $response->getCode());
        $this->assertStringMatchesFormat($expected['getInvoiceNumber'], $response->getInvoiceNumber());
        $this->assertStringMatchesFormat($expected['getTransactionId'], $response->getTransactionId());
        $this->assertStringStartsWith($expected['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertStringMatchesFormat($expected['getMessage'], $response->getMessage());
        $this->assertStringMatchesFormat($expected['getAuthorizationCode'], $response->getAuthorizationCode());
    }

    /**
     * Purchase Testing Data Provider
     */
    public function purchaseDataProvider()
    {

        $formData = [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $transactionOptionsOk = [
            'amount' => '888.88',
            'currency' => 'USD',
            'card' => $formData
        ];

        $transactionOptionsFailure = [
            'amount' => '0',
            'currency' => 'USD',
        ];

        return [
            [
                $transactionOptionsOk,
                [
                    'expectedException' => null,
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getInvoiceNumber' => '%i',
                    'getTransactionId' => '%i-%i-%i',
                    'getAVSResponse' => 'AVS Match',
                    'getCVV2Response' => '',
                    'getTransactionResponse' => 'YAPPROVED',
                    'getMessage' => '"%S","%S","%S","%S","%S"',
                    'getAuthorizationCode' => '%i',
                ]
            ],
           [
               $transactionOptionsFailure,
               [
                   'expectedException' => '\Omnipay\Common\Exception\InvalidRequestException',
                   'isSuccessful' => false,
                   'getCode' => 'U',
                   'getInvoiceNumber' => '',
                   'getTransactionId' => '',
                   'getAVSResponse' => '',
                   'getCVV2Response' => '',
                   'getTransactionResponse' => '',
                   'getMessage' => '',
                   'getAuthorizationCode' => '',
               ]
           ],
        ];
    }


    /**
     * Capture Transaction Testing Data Provider
     */
    public function captureDataProvider()
    {

        $formData = [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $transactionOptions = [
            'transactionId' => '20140630120024-080880-224491',
            'currency' => 'USD',
            'card' => $formData
        ];

        // Fails due to transactionId doesn't match any in the system.
        return [
            [
                $transactionOptions,
                [
                    'expectedException' => null,
                    'isSuccessful' => false,
                    'getCode' => 'U',
                    'getInvoiceNumber' => '',
                    'getTransactionId' => '',
                    'getAVSResponse' => '',
                    'getCVV2Response' => '',
                    'getTransactionResponse' => 'UIncomplete information - Transaction not compatible',
                    'getMessage' => '"%S"',
                    'getAuthorizationCode' => '',
                ]
            ],

        ];
    }


    /**
     * Refund Transaction Testing Data Provider
     */
    public function refundDataProvider()
    {

        $formData = [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $transactionOptions = [
            'amount' => '28.88',
            'currency' => 'USD',
            'card' => $formData
        ];

        // Fails due to transactionId doesn't match any in the system.
        return [
            [
                $transactionOptions,
                [
                    'expectedException' => null,
                    'isSuccessful' => false,
                    'getCode' => 'U',
                    'getInvoiceNumber' => '',
                    'getTransactionId' => '',
                    'getAVSResponse' => '',
                    'getCVV2Response' => '',
                    'getTransactionResponse' => 'UIncomplete information - Transaction Type',
                    'getMessage' => '"%S"',
                    'getAuthorizationCode' => '',
                ]
            ],
        ];
    }

    /**
     * Create Card Transaction Testing Data Provider
     */
    public function createCardDataProvider()
    {

        $formData = [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];

        $transactionOptions = [
            'amount' => '28.88',
            'currency' => 'USD',
            'card' => $formData
        ];

        // Fails due to transactionId doesn't match any in the system.
        return [
            [
                $transactionOptions,
                [
                    'expectedException' => null,
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getInvoiceNumber' => '%i',
                    'getTransactionId' => '%i-%i-%i',
                    'getAVSResponse' => '',
                    'getCVV2Response' => '',
                    'getTransactionResponse' => 'YSUCCESSFUL',
                    'getMessage' => '"%S"',
                    'getAuthorizationCode' => '',
                ]
            ],
        ];
    }


    /**
     * Charge Stored Credit Card Transaction Testing Data Provider
     */
    public function chargeStoredCardDataProvider()
    {
        $transactionOptions = [
            'transactionId' => '20140630191636-080880-224589',
            'amount' => '1000.88',
            'currency' => 'USD',
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingPostcode' => '1234',
            'billingAddress1' => '123 Fake St.',
        ];

        // Fails due to transactionId doesn't match any in the system.
        return [
            [
                $transactionOptions,
                [
                    'expectedException' => null,
                    'isSuccessful' => false,
                    'getCode' => 'U',
                    'getInvoiceNumber' => '',
                    'getTransactionId' => '',
                    'getAVSResponse' => '',
                    'getCVV2Response' => '',
                    'getTransactionResponse' => 'UIncomplete information',
                    'getMessage' => '"%S"',
                    'getAuthorizationCode' => '',
                ]
            ],
        ];
    }
}
