<?php
namespace Tests\Functional;

/**
 * Voiding a Sale
 *
 * Use a void transaction to remove a captured transaction from the current batch. You
 * cannot void a transaction that is not in the current batch. If the transaction you want to
 * void is in a batch that you have already closed, you must run a return transaction instead.
 */
class VoidTransactionTest extends \PHPUnit_Framework_TestCase
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
     * Tests a PURCHASE action passing an amount and a Credit Card to EPN.
     *
     * @group Sale
     */
    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'amount' => '70.00',
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

        self::$messages[] = 'Transaction ID [Sale]: ' . self::$transactionId;
    }

    /**
     * Tests that a previously generated transactionId can be "Voided".
     *
     * @group Void
     * @depends testPurchase
     */
    public function testVoid()
    {
        $request = $this->gateway->void([
            'transactionId' => self::$transactionId
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        self::$messages[] = 'Transaction ID [Void]: ' . $response->getTransactionId();
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
