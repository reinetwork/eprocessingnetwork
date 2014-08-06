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

        $expectedValues = [
            'getMessage' => 'YAPPROVED 275752',
            'getTransactionResponse' => '"YAPPROVED 275752","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","234523","20140806153047-080880-234523"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '275752',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806153047-080880-234523',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());

    }

    public function testAuthorizeDeclined()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeFailedDeclined.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $expectedValues = [
            'getMessage' => 'NDECLINED',
            'getTransactionResponse' => '"NDECLINED","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)"',
            'getCode' => 'N',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '',
        ];

        $this->assertFalse($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
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

        $expectedValues = [
            'getMessage' => 'YAPPROVED 444716',
            'getTransactionResponse' => '"YAPPROVED 444716","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","234540","20140806165304-080880-234540"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '444716',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806165304-080880-234540',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
    }

    public function testCaptureSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CaptureSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $expectedValues = [
            'getMessage' => 'YSUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL","","","24","20140630191636-080880-224589"',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140630191636-080880-224589',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());

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

        $expectedValues = [
            'getMessage' => 'NCannot Find Xact',
            'getTransactionResponse' => '"NCannot Find Xact","","","12056","20140805121859-080880-12056-0"',
            'getCode' => 'N',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140805121859-080880-12056-0',
        ];

        $this->assertFalse($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
    }

    public function testVoidSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('VoidSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $expectedValues = [
            'getMessage' => 'YSUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL","","","27","20140630191636-080880-224589"',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140630191636-080880-224589',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
    }

    public function testStoreCardSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('StoreCardSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $expectedValues = [
            'getMessage' => 'YSUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL",""',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
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

        $expectedValues = [
            'getMessage' => 'YAPPROVED 295608',
            'getTransactionResponse' => '"YAPPROVED 295608","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","234536","20140806162857-080880-234536"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '295608',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806162857-080880-234536',
        ];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());
    }
}
