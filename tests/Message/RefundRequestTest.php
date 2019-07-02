<?php
namespace Omnipay\eProcessingNetwork\Message;

use Mockery;
use Omnipay\Common\Http\ClientInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RefundRequestTest extends TestCase
{
    /**
     * @var RefundRequest
     */
    public $testClass;

    public function setUp()
    {
        $mockClient = Mockery::mock(ClientInterface::class);
        $mockHttpRequest = Mockery::mock(Request::class);
        $this->testClass = new RefundRequest($mockClient, $mockHttpRequest);
    }

    public function testGetData()
    {
        $this->testClass->setAmount('888.9');
        $card = new \Omnipay\Common\CreditCard([
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'billingAddress1' => '123 Fake St.',
            'billingPostcode' => '1234',
            'number' => '4242424242424242',
            'expiryMonth' => '6',
            'expiryYear' => '2099',
            'cvv' => '123'
        ]);
        $this->testClass->setCard($card);
        $actual = $this->testClass->getData();

        $expected = [
            'ePNAccount' => null,
            'RestrictKey' => null,
            'HTML' => 'No',
            'TranType' => 'Return',
            'CardNo' => '4242424242424242',
            'ExpMonth' => 6,
            'ExpYear' => 2099,
            'CVV2' => '123',
            'Total' => '888.90',
            'Inv' => 'report',
            'Description' => null,
            'FirstName' => 'TestFirstName',
            'LastName' => 'TestLastName',
            'Company' => null,
            'Address' => '123 Fake St.',
            'City' => null,
            'State' => null,
            'Zip' => '1234',
            'Country' => null,
            'Phone' => null,
            'EMail' => null,
            'CVV2Type' => 0
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * Validates that the Request message has the expected Data when using
     * a Transaction-Id instead of a Credit Card.
     */
    public function testGetDataWithoutCreditCardButTransactionId()
    {

        $this->testClass->setTransactionId('1234-5678');
        $this->testClass->setAmount(50.99);

        $expected = [
            'ePNAccount'  => null,
            'RestrictKey' => null,
            'HTML'        => 'No',
            'CVV2Type'    => 0,
            'TranType'    => 'Return',
            'Total'       => '50.99',
            'Inv'         => 'report',
            'Description' => null,
            'TransID'     => '1234-5678',
        ];

        $actual = $this->testClass->getData();

        $this->assertEquals($expected, $actual);

    }
}
