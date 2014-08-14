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

    /**
     * @dataProvider responsesDataProvider
     */
    public function testResponses($mockFile, $expectedValues)
    {
        $httpResponse = $this->getMockHttpResponse($mockFile);
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());

        $this->assertSame($expectedValues['isSuccessful'], $response->isSuccessful());
        $this->assertSame($expectedValues['getMessage'], $response->getMessage());
        $this->assertSame($expectedValues['getTransactionResponse'], $response->getTransactionResponse());
        $this->assertSame($expectedValues['getCode'], $response->getCode());
        $this->assertSame($expectedValues['getCVV2Response'], $response->getCVV2Response());
        $this->assertSame($expectedValues['getAuthorizationCode'], $response->getAuthorizationCode());
        $this->assertSame($expectedValues['getAVSResponse'], $response->getAVSResponse());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionId());
        $this->assertSame($expectedValues['getTransactionId'], $response->getTransactionReference());

    }

    /**
     * @dataProvider exceptionsDataProvider
     */
    public function testRequestThrowsException($mockFile)
    {
        $this->setExpectedException(
            'Omnipay\Common\Exception\InvalidResponseException',
            'Invalid response from payment gateway'
        );

        $httpResponse = $this->getMockHttpResponse($mockFile);
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
    }


    public function exceptionsDataProvider()
    {
        return [
            ['AuthorizeFailedInvalidCard.txt'],
            ['CaptureFailed.txt'],
            ['StoreCardFailed.txt'],
        ];
    }


    public function responsesDataProvider()
    {
        $expectedValues0 = [
            'isSuccessful' => true,
            'getMessage' => 'APPROVED 275752',
            'getTransactionResponse' => '"YAPPROVED 275752","AVS Match 9 Digit Zip and Address (X)",'
                . '"CVV2 Match (M)","234523","20140806153047-080880-234523"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '275752',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806153047-080880-234523',
            'getTransactionReference' => '20140806153047-080880-234523',
        ];

        $expectedValues1 = [
            'isSuccessful' => false,
            'getMessage' => 'DECLINED',
            'getTransactionResponse' => '"NDECLINED","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)"',
            'getCode' => 'N',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '',
        ];

        $expectedValues2 = [
            'isSuccessful' => true,
            'getMessage' => 'APPROVED 444716',
            'getTransactionResponse' => '"YAPPROVED 444716","AVS Match 9 Digit Zip and Address (X)",'
                . '"CVV2 Match (M)","234540","20140806165304-080880-234540"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '444716',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806165304-080880-234540',
        ];

        $expectedValues3 = [
            'isSuccessful' => true,
            'getMessage' => 'SUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL","","","24","20140630191636-080880-224589"',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140630191636-080880-224589',
        ];

        $expectedValues4 = [
            'isSuccessful' => false,
            'getMessage' => 'Cannot Find Xact',
            'getTransactionResponse' => '"NCannot Find Xact","","","12056","20140805121859-080880-12056-0"',
            'getCode' => 'N',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140805121859-080880-12056-0',
        ];

        $expectedValues5 = [
            'isSuccessful' => true,
            'getMessage' => 'SUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL","","","27","20140630191636-080880-224589"',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140630191636-080880-224589',
        ];

        $expectedValues6 = [
            'isSuccessful' => true,
            'getMessage' => 'SUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL",""',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '',
        ];

        $expectedValues7 = [
            'isSuccessful' => true,
            'getMessage' => 'APPROVED 295608',
            'getTransactionResponse' => '"YAPPROVED 295608","AVS Match 9 Digit Zip and Address (X)",'
                . '"CVV2 Match (M)","234536","20140806162857-080880-234536"',
            'getCode' => 'Y',
            'getCVV2Response' => 'CVV2 Match (M)',
            'getAuthorizationCode' => '295608',
            'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
            'getTransactionId' => '20140806162857-080880-234536',
        ];

        $expectedValues8 = [
            'isSuccessful' => true,
            'getMessage' => 'SUCCESSFUL',
            'getTransactionResponse' => '"YSUCCESSFUL","","","236846","20140814175343-080880-236846"',
            'getCode' => 'Y',
            'getCVV2Response' => '',
            'getAuthorizationCode' => '',
            'getAVSResponse' => '',
            'getTransactionId' => '20140814175343-080880-236846',
        ];

        return [
            ['AuthorizeSuccess.txt', $expectedValues0],
            ['AuthorizeFailedDeclined.txt', $expectedValues1],
            ['PurchaseSuccess.txt', $expectedValues2],
            ['CaptureSuccess.txt', $expectedValues3],
            ['CaptureFailedTransactionNotFound.txt', $expectedValues4],
            ['VoidSuccess.txt', $expectedValues5],
            ['StoreCardSuccess.txt', $expectedValues6],
            ['ChargeStoreCardSuccess.txt', $expectedValues7],
            ['AuthDelSuccess.txt', $expectedValues8],
        ];
    }
}
