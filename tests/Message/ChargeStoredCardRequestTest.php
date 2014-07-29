<?php
namespace Omnipay\eProcessingNetwork\Message;

class ChargeStoredCardRequestTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $mockClient = $this->getMockBuilder('Guzzle\Http\ClientInterface')->getMock();
        $mockHttpRequest = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')->getMock();
        $this->testClass = new ChargeStoredCardRequest($mockClient, $mockHttpRequest);
    }

    public function testGetData()
    {
        $this->testClass->setAmount('888.9');
        $this->testClass->setTransactionId('1111-2222-3333');

        $actual = $this->testClass->getData();

        $expected = [
            'ePNAccount' => null,
            'RestrictKey' => null,
            'HTML' => 'No',
            'TranType' => 'Sale',
            'Inv' => null,
            'TransID' => '1111-2222-3333',
            'FirstName' => null,
            'LastName' => null,
            'Address' => '',
            'City' => null,
            'State' => null,
            'Zip' => null,
            'Phone' => null,
            'Description' => null,
            'Total' => '888.90',
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
