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

    public function testAuthorizeDeclined()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeFailedDeclined.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('NDECLINED', $response->getTransactionResponse());
        $this->assertSame('"NDECLINED","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)"', $response->getMessage());
        $this->assertSame('N', $response->getCode());
        $this->assertSame('', $response->getAuthorizationCode());
        $this->assertSame('AVS Match 9 Digit Zip and Address (X)', $response->getAVSResponse());
    }

    public function testAuthorizeInvalidCardThrowsException()
    {
        $this->setExpectedException(
            'Omnipay\Common\Exception\InvalidResponseException',
            'Invalid response from payment gateway'
        );

        $httpResponse = $this->getMockHttpResponse('AuthorizeFailedInvalidCard.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
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

    public function testCaptureFailsThrowsException()
    {
        $this->setExpectedException(
            'Omnipay\Common\Exception\InvalidResponseException',
            'Invalid response from payment gateway'
        );

        $httpResponse = $this->getMockHttpResponse('CaptureFailed.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
    }

    public function testCaptureFailsTransactionNotFound()
    {
        $httpResponse = $this->getMockHttpResponse('CaptureFailedTransactionNotFound.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('NCannot Find Xact', $response->getTransactionResponse());
        $this->assertSame('"NCannot Find Xact","","","12056","20140805121859-080880-12056-0"', $response->getMessage());
        $this->assertSame('N', $response->getCode());
        $this->assertSame('', $response->getCVV2Response());
        $this->assertSame('20140805121859-080880-12056-0', $response->getTransactionId());
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

    public function testStoreCardFailsThrowsException()
    {
        $this->setExpectedException(
            'Omnipay\Common\Exception\InvalidResponseException',
            'Invalid response from payment gateway'
        );

        $httpResponse = $this->getMockHttpResponse('StoreCardFailed.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
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
