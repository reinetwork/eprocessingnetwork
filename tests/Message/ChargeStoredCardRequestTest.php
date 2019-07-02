<?php
namespace Omnipay\eProcessingNetwork\Message;

use Mockery;
use Omnipay\Common\Http\ClientInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ChargeStoredCardRequestTest extends TestCase
{

    public function setUp()
    {
        $mockClient = Mockery::mock(ClientInterface::class);
        $mockHttpRequest = Mockery::mock(Request::class);
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
            'Inv' => 'report',
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
            'CVV2Type' => 0
        ];

        $this->assertEquals($expected, $actual);
    }


    public function testGetDataThrowsException()
    {
        $this->expectException('\Omnipay\Common\Exception\InvalidRequestException');
        $this->testClass->setAmount('100.00');

        $message = $this->testClass->getData();

    }
}
