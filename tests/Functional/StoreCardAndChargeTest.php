<?php
namespace Tests\Functional;

/**
 * Verifies that a given Credit Card can be STORED in the eProcessingNetwork system, and
 * after that it can be charged.
 *
 * Store
 *
 * Stores the cardholder’s credit card data on the TDBE without
 * processing a transaction. To process future transactions against the
 * cardholder’s data,. use the TransID returned in the response.
 */
class StoreCardAndChargeTest extends \PHPUnit_Framework_TestCase
{
    protected $gateway;

    //for persistance
    public static $transactionId;
    public static $messages = [];

    public function setUp()
    {
        parent::setUp();

        $this->gateway = \Omnipay\Omnipay::create('\Omnipay\eProcessingNetwork\Gateway');

        $this->gateway->setApiLoginId('080880');
        $this->gateway->setApiRestrictKey('yFqqXJh9Pqnugfr');
        $this->gateway->setDeveloperMode(false);

        $this->cardData = [
            'firstName' => 'Functional_Test_FirstName',
            'lastName' => 'Functional_Test_LastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2016',
            'cvv' => '123'
        ];
    }

    /**
     * Tests that a Credit Card can ge STORED in the EPN system.
     *
     * @group Store
     */
    public function testCreateCard()
    {
        $request = $this->gateway->createCard([
            'card' => $this->cardData
        ]);

        //
        $this->assertSame(
            'https://www.eprocessingnetwork.com/cgi-bin/tdbe/transact.pl',
            $request->getEndpoint()
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        self::$transactionId = $response->getTransactionId();

        self::$messages[] = 'Transaction ID [Store]: ' . self::$transactionId;
    }

    /**
     * Tests that a previously generated transactionId (of a STORE action) can be charged.
     *
     * @group Auth2Sale
     * @depends testCreateCard
     */
    public function testCharge()
    {
        $request = $this->gateway->chargeStoredCard([
            'transactionId' => self::$transactionId,
            'amount' => '21.00'
        ]);

        //The address should match the stored card.
        $request->setBillingAddress1('123 Fake St.');
        $request->setBillingPostcode('1234');

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        self::$messages[] = 'Transaction ID [Auth2Sale]: ' . self::$transactionId;
    }

    /**
     * Displays the stored messages once the test finishes.
     */
    public static function tearDownAfterClass()
    {
        echo PHP_EOL . __CLASS__ . PHP_EOL;
        echo implode(PHP_EOL, self::$messages);
        echo PHP_EOL;
    }
}
