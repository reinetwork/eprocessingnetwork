<?php
namespace Omnipay\eProcessingNetwork\Message;
use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @expectedException Omnipay\Common\Exception\InvalidResponseException
     */
    public function testConstructEmpty()
    {
        $response = new Response($this->getMockRequest(), '');
    }

    public function testAuthorizeSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YAPPROVED 275752', $response->getTransactionResponse());
        $this->assertSame('"YAPPROVED 275752","AVS Match 9 Digit Zip and Address (X)"', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
        $this->assertSame('275752', $response->getAuthorizationCode());
        $this->assertSame('AVS Match 9 Digit Zip and Address (X)', $response->getAVSResponse());
    }

    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YAPPROVED 444716', $response->getTransactionResponse());
        $this->assertSame('"YAPPROVED 444716","AVS Match 9 Digit Zip and Address (X)"', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
        $this->assertSame('444716', $response->getAuthorizationCode());
        $this->assertSame('AVS Match 9 Digit Zip and Address (X)', $response->getAVSResponse());
    }

    public function testCaptureSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CaptureSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YSUCCESSFUL', $response->getTransactionResponse());
        $this->assertSame('"YSUCCESSFUL","","","24","20140630191636-080880-224589"', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
        $this->assertSame('', $response->getCVV2Response());
        $this->assertSame('20140630191636-080880-224589', $response->getTransactionId());
    }

    public function testVoidSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('VoidSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YSUCCESSFUL', $response->getTransactionResponse());
        $this->assertSame('"YSUCCESSFUL","","","27","20140630191636-080880-224589"', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
        $this->assertSame('20140630191636-080880-224589', $response->getTransactionId());
    }

    public function testStoreCardSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('StoreCardSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YSUCCESSFUL', $response->getTransactionResponse());
        $this->assertSame('"YSUCCESSFUL",""', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
    }

    public function testChargeStoreCardSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('ChargeStoreCardSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('YAPPROVED 295608', $response->getTransactionResponse());
        $this->assertSame('"YAPPROVED 295608","AVS Match 9 Digit Zip and Address (X)"', $response->getMessage());
        $this->assertSame('Y', $response->getCode());
        $this->assertSame('295608', $response->getAuthorizationCode());
        $this->assertSame('AVS Match 9 Digit Zip and Address (X)', $response->getAVSResponse());
    }
}
