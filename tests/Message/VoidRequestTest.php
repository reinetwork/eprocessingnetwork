<?php
namespace REINetwork\eProcessingNetwork\Message;

class VoidRequestTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $mockClient = $this->getMockBuilder('Guzzle\Http\ClientInterface')->getMock();
        $mockHttpRequest = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')->getMock();
        $this->testClass = new VoidRequest($mockClient, $mockHttpRequest);
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
            'expiryYear' => '2016',
            'cvv' => '123'
        ]);
        $this->testClass->setCard($card);
        $this->testClass->setTransactionId('1234-1234-1234-1234');
        $actual = $this->testClass->getData();

        $expected = [
            'ePNAccount' => null,
            'RestrictKey' => null,
            'HTML' => 'No',
            'TranType' => 'Void',
            'Inv' => null,
            'TransID' => '1234-1234-1234-1234',
            'Total' => '888.90',
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
        ];

        $this->assertEquals($expected, $actual);
    }


    public function testGetDataThrowsException()
    {
        $this->setExpectedException('\Omnipay\Common\Exception\InvalidRequestException');
        $this->testClass->setAmount('100.00');

        $message = $this->testClass->getData();

    }
}
