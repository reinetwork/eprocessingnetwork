<?php
namespace Tests\Functional;

/**
 * AuthDel
 *
 * Use the AuthDel method to delete an authorization only transaction that you do not
 * want to capture. Use the AuthDel TranType. As with the Auth2Sale TranType, submit the
 * TransID of the original transaction to delete.
 */
class RemoveAuthorizedTransactionFromBatchTest extends \PHPUnit_Framework_TestCase
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
     * Tests that a previously generated transactionId can be "deleted" from the batch.
     *
     * @group AuthDel
     * @depends testAuthorize
     */
    public function testRemove()
    {
        $request = $this->gateway->removeAuthorizedTransaction([
            'transactionId' => self::$transactionId
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        /**
         * The response contains a new TransID
         * because the original authorization has been
         * deleted and no longer exists.
         */
        $this->assertNotEquals(self::$transactionId, $response->getTransactionId());
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
