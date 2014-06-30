<?php

namespace REINetwork\eProcessingNetwork\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * eProcessingNetwork AIM Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = explode('","', substr($data, 1, -1));

        if (count($this->data) < 1) {
            throw new InvalidResponseException();
        }

    }

    public function isSuccessful()
    {

        return (stripos($this->data[0], 'YAPPROVED') !== false);
    }

    public function getCode()
    {
        return substr($this->data[0], 0, 1);
    }

    public function getReasonCode()
    {
        return $this->data[2];
    }

    public function getMessage()
    {
        return $this->data[0];
    }

    public function getAuthorizationCode()
    {
        return filter_var($this->data[0], FILTER_SANITIZE_NUMBER_INT);
    }

    public function getAVSCode()
    {
        return $this->data[1];
    }

    public function getTransactionReference()
    {
        return $this->data[6];
    }
}
