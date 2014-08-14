<?php
namespace Tests\Functional;

/**
 * Verifies that a transaction can be refunded.
 *
 * Return
 *
 * Refunds money to the cardholder. You can use either the CardNo field
 * or the TransID to refund money for an existing transaction.
 */
class RefundTest extends \PHPUnit_Framework_TestCase
{
    protected $gateway;

    //for persistance
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
     * Tests that can RETURN money to a given card.
     *
     * @group Return
     */
    public function testRefund()
    {
        $request = $this->gateway->refund([
            'amount' => '5.00',
            'card' => $this->cardData
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        self::$messages[] = 'Transaction ID [Return]: ' . $response->getTransactionId();
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
