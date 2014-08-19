<?php
namespace Tests\Functional;

/**
 * Verifies that an authorized transaction can be captured.
 *
 * Authorization Only
 *
 * An authorization only transaction verifies that the cardholder has sufficient funds to
 * cover the transaction; however, it does not capture the transaction in the batch to transfer
 * funds.
 *
 * Auth2Sale
 *
 * Capture a transaction previously approved using AuthOnly. Use the
 * TransID returned in the original authorization.
 */
class AuthorizeAndCapture extends \PHPUnit_Framework_TestCase
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
     * Tests an actual AUTHORIZE transaction and sets the returned transactionId.
     *
     * @group AuthOnly
     */
    public function testAuthorize()
    {
        $request = $this->gateway->authorize([
            'amount' => '80.00',
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

        self::$messages[] = 'Transaction ID [AuthOnly]: ' . self::$transactionId;
    }

    /**
     * Tests that a previously generated transactionId can be "captured".
     *
     * @group Auth2Sale
     * @depends testAuthorize
     */
    public function testCapture()
    {
        $request = $this->gateway->capture([
            'transactionId' => self::$transactionId
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
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
