<?php
namespace REINetwork\eProcessingNetwork\Message;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testGetData($data, $expected)
    {
        $mockRequest = $this->getMockBuilder('Omnipay\Common\Message\RequestInterface')->getMock();
        $this->testClass = new Response($mockRequest, $data);

        $this->assertEquals($expected['getTransactionResponse'], $this->testClass->getTransactionResponse());
        $this->assertEquals($expected['isSuccessful'], $this->testClass->isSuccessful());
        $this->assertEquals($expected['getCode'], $this->testClass->getCode());
        $this->assertEquals($expected['getCVV2Response'], $this->testClass->getCVV2Response());
        $this->assertEquals($expected['getMessage'], $this->testClass->getMessage());
        $this->assertEquals($expected['getAuthorizationCode'], $this->testClass->getAuthorizationCode());
        $this->assertEquals($expected['getAVSResponse'], $this->testClass->getAVSResponse());
        $this->assertEquals($expected['getTransactionId'], $this->testClass->getTransactionId());
        $this->assertEquals($expected['getInvoiceNumber'], $this->testClass->getInvoiceNumber());
    }


    public function dataProvider()
    {

        $authorizeSuccess = '"YAPPROVED 755596","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)"';
        $authDelSuccess = '"YSUCCESSFUL","","","24","20080828155713-080880-25"';
        $purchaseWithInvoice = '"YAPPROVED 184752","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","23","20080828140719-080880-23"';
        $voidSaleSuccess = '"YAPPROVED 334512","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","27","20080828161434-080880-27"';
        $storeCardSuccess = '"YSUCCESSFUL","AVS Service Not Supported (S)","","4048","20090720105945-080880-4048"';
        $saleFromTransSuccess = '"YAPPROVED 475288","AVS Match 9 Digit Zip and Address (X)","","28","20080828163249-080880-28"';
        $incompleteInformation = "UIncomplete information - ePNAccount";

        return [
            [
                $authorizeSuccess,
                [
                    'getTransactionResponse' => 'YAPPROVED 755596',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => 'CVV2 Match (M)',
                    'getMessage' => $authorizeSuccess,
                    'getAuthorizationCode' => '755596',
                    'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
                    'getTransactionId' => '',
                    'getInvoiceNumber' => '',
                ],
            ],
            [
                $authDelSuccess,
                [
                    'getTransactionResponse' => 'YSUCCESSFUL',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => '',
                    'getMessage' => $authDelSuccess,
                    'getAuthorizationCode' => '',
                    'getAVSResponse' => '',
                    'getTransactionId' => '20080828155713-080880-25',
                    'getInvoiceNumber' => '24',
                ],
            ],
            [
                $purchaseWithInvoice,
                [
                    'getTransactionResponse' => 'YAPPROVED 184752',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => 'CVV2 Match (M)',
                    'getMessage' => $purchaseWithInvoice,
                    'getAuthorizationCode' => '184752',
                    'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
                    'getTransactionId' => '20080828140719-080880-23',
                    'getInvoiceNumber' => '23',
                ],
            ],
            [
                $voidSaleSuccess,
                [
                    'getTransactionResponse' => 'YAPPROVED 334512',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => 'CVV2 Match (M)',
                    'getMessage' => $voidSaleSuccess,
                    'getAuthorizationCode' => '334512',
                    'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
                    'getTransactionId' => '20080828161434-080880-27',
                    'getInvoiceNumber' => '27',
                ],
            ],
            [
                $storeCardSuccess,
                [
                    'getTransactionResponse' => 'YSUCCESSFUL',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => '',
                    'getMessage' => $storeCardSuccess,
                    'getAuthorizationCode' => '',
                    'getAVSResponse' => 'AVS Service Not Supported (S)',
                    'getTransactionId' => '20090720105945-080880-4048',
                    'getInvoiceNumber' => '4048',
                ],
            ],
            [
                $saleFromTransSuccess,
                [
                    'getTransactionResponse' => 'YAPPROVED 475288',
                    'isSuccessful' => true,
                    'getCode' => 'Y',
                    'getCVV2Response' => '',
                    'getMessage' => $saleFromTransSuccess,
                    'getAuthorizationCode' => '475288',
                    'getAVSResponse' => 'AVS Match 9 Digit Zip and Address (X)',
                    'getTransactionId' => '20080828163249-080880-28',
                    'getInvoiceNumber' => '28',
                ],
            ],
            [
                $incompleteInformation,
                [
                    'getTransactionResponse' => 'Incomplete information - ePNAccoun',
                    'isSuccessful' => false,
                    'getCode' => 'I',
                    'getCVV2Response' => '',
                    'getMessage' => $incompleteInformation,
                    'getAuthorizationCode' => '',
                    'getAVSResponse' => '',
                    'getTransactionId' => '',
                    'getInvoiceNumber' => '',
                ],
            ],
        ];
    }
}
