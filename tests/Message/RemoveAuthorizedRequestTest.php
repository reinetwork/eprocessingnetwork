<?php
namespace Tests\Message;

use Omnipay\eProcessingNetwork\Message\RemoveAuthorizedRequest;

class VoidRequestTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $mockClient = $this->getMockBuilder('Guzzle\Http\ClientInterface')->getMock();
        $mockHttpRequest = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')->getMock();
        $this->testClass = new RemoveAuthorizedRequest($mockClient, $mockHttpRequest);
    }

    public function testGetData()
    {
        $this->testClass->setTransactionId('1234-1234-1234-1234');
        $actual = $this->testClass->getData();

        $expected = [
            'ePNAccount' => null,
            'RestrictKey' => null,
            'HTML' => 'No',
            'TranType' => 'AuthDel',
            'TransID' => '1234-1234-1234-1234',
            'CVV2Type' => 0
        ];

        $this->assertEquals($expected, $actual);
    }


    public function testGetDataThrowsException()
    {
        $this->setExpectedException('\Omnipay\Common\Exception\InvalidRequestException');

        $message = $this->testClass->getData();
    }
}
