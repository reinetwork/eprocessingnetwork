<?php

namespace REINetwork\eProcessingNetwork\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * eProcessingNetwork Response
 */
class Response extends AbstractResponse
{
    public $data;
    public $responseString;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = explode('","', substr($data, 1, -1));

        if (count($this->data) < 1) {
            throw new InvalidResponseException();
        }
        $this->responseString = (string) $data;
    }

    /**
     * 1 | Transaction Response |
     *    The approval response. The response starts with one of the following 1-character value
     *    indicating the success of the transaction:
     *    Y – Approved
     *    N – Declined
     *    U – Unable to perform the transaction
     *    The 1-character response is followed by up to 16 characters explaining the response, for example:
     *    APPROVED 123456.
     *
     * @return string
     */
    public function getTransactionResponse()
    {
        return $this->data[0];
    }

    public function isSuccessful()
    {
        return (stripos($this->getCode(), 'Y') !== false);
    }

    public function getCode()
    {
        return substr($this->data[0], 0, 1);
    }

    /**
     * 3 | AVS Response |
     *   The CVV2 response returned by the issuing bank.
     *   TDBE only returns this value if CVV2 is used for the transaction.
     * @return string
     */
    public function getCVV2Response()
    {
        return isset($this->data[2]) ? $this->data[2] : '';
    }

    public function getMessage()
    {
        return $this->responseString;
    }

    public function getAuthorizationCode()
    {
        return preg_replace("/[^0-9]/","",$this->data[0]);
    }

    /**
     * 2 | AVS Response |
     * The AVS response returned by the issuing bank.
     * @return string
     */
    public function getAVSResponse()
    {
        return isset($this->data[1]) ? $this->data[1] : '';
    }

    /**
     * 5 | Transaction ID |
     * The transaction ID (TransID) that identifies this transaction on the TDBE. Use the TransID to reference
     * -this transaction in other transactions, such as Voids and Returns. The format for the TransID value is:
     * timestamp-account number-invoice number
     * Some transaction IDs includes a fourth value:
     * -0 for declines;
     * -6 for checks;
     * -5 for voids.
     * TDBE only returns this value if you submit the Inv field in the request.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return isset($this->data[4]) ? $this->data[4] : '';
    }

    /**
     * 4 | Invoice Number |
     * Invoice number for the transaction. The TDBE only returns this value if you submit the Inv field in the request.
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return isset($this->data[3]) ? $this->data[3] : '';
    }


}
