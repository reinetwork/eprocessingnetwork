<?php

namespace Omnipay\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://www.eprocessingnetwork.com/cgi-bin/tdbe/transact.pl';
    protected $developerEndpoint = 'https://www.eprocessingnetwork.com/cgi-bin/Reflect/transact.pl';

    public function getApiLoginId()
    {
        return $this->getParameter('apiLoginId');
    }

    public function setApiLoginId($value)
    {
        return $this->setParameter('apiLoginId', $value);
    }

    public function getApiRestrictKey()
    {
        return $this->getParameter('apiRestrictKey');
    }

    public function setApiRestrictKey($value)
    {
        return $this->setParameter('apiRestrictKey', $value);
    }

    public function setTransactionReference($value)
    {
        return $this->setTransactionId($value);
    }

    public function getTransactionReference()
    {
        return $this->getTransactionId();
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function getInvoiceNumber()
    {
        // invoice number required to get TransactionId
        $value = $this->getParameter('invoiceNumber');
        return strlen($value) > 0 ? $value : 'report';
    }

    public function setInvoiceNumber($value)
    {
        return $this->setParameter('invoiceNumber', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getCvv2Type()
    {
        // default to not using cvv2
        $type = $this->getParameter('cvv2Type');
        return strlen($type) > 0 ? $type : 0;
    }

    public function setCvv2Type($value)
    {
        return $this->setParameter('cvv2Type', $value);
    }

    protected function getBaseData()
    {
        $data = array();
        $data['ePNAccount'] = $this->getApiLoginId();
        $data['RestrictKey'] = $this->getApiRestrictKey();
        $data['HTML'] = 'No';
        $data['CVV2Type'] = $this->getCvv2Type();

        return $data;
    }

    protected function getBillingData()
    {
        $data = array();
        $data['Total'] = $this->getAmount();
        $data['Inv'] = $this->getInvoiceNumber();
        $data['Description'] = $this->getDescription();

        if ($card = $this->getCard()) {
            // customer billing details
            $data['FirstName'] = $card->getBillingFirstName();
            $data['LastName'] = $card->getBillingLastName();
            $data['Company'] = $card->getBillingCompany();
            $data['Address'] = trim(
                $card->getBillingAddress1()." \n".
                $card->getBillingAddress2()
            );
            $data['City'] = $card->getBillingCity();
            $data['State'] = $card->getBillingState();
            $data['Zip'] = $card->getBillingPostcode();
            $data['Country'] = $card->getBillingCountry();
            $data['Phone'] = $card->getBillingPhone();
            $data['EMail'] = $card->getEmail();
        }

        return $data;
    }

    public function sendData($data)
    {
        //print_r($data);
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }

    public function getEndpoint()
    {
        return $this->getDeveloperMode() ? $this->developerEndpoint : $this->liveEndpoint;
    }
}
