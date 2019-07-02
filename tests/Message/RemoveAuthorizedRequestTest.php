<?php
namespace Tests\Message;

use Mockery;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\eProcessingNetwork\Message\RemoveAuthorizedRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class VoidRequestTest extends TestCase
{

    public function setUp()
    {
        $mockClient = Mockery::mock(ClientInterface::class);
        $mockHttpRequest = Mockery::mock(Request::class);
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
        $this->expectException('\Omnipay\Common\Exception\InvalidRequestException');

        $message = $this->testClass->getData();
    }
}
