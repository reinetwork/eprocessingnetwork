<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork ChargeStoredCard Request
 */
class ChargeStoredCardRequest extends AbstractRequest
{
    protected $action = 'Sale';

    public function getData()
    {
        $this->validate('amount', 'transactionId');

        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['Inv'] = 'report';
        $data['TransID'] = $this->getTransactionId();

        $data['FirstName'] = $this->getFirstName();
        $data['LastName'] = $this->getLastName();
        $data['Address'] = trim(
            $this->getBillingAddress1() . " \n" .
            $this->getBillingAddress2()
        );

        $data['City'] = $this->getCity();
        $data['State'] = $this->getState();
        $data['Zip'] = $this->getBillingPostcode();
        $data['Phone'] = $this->getPhone();
        $data['Description'] = $this->getDescription();

        return array_merge($data, $this->getBillingData());
    }

    //Setters & Getters are required because of Helper::initialize
    //
    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    public function getLastName()
    {
        return $this->getParameter('lastName');
    }

    public function setLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }

    public function getBillingAddress1()
    {
        return $this->getParameter('billingAddress1');
    }

    public function setBillingAddress1($value)
    {
        return $this->setParameter('billingAddress1', $value);
    }

    public function getBillingAddress2()
    {
        return $this->getParameter('billingAddress2');
    }

    public function setBillingAddress2($value)
    {
        return $this->setParameter('billingAddress2', $value);
    }

    public function getCity()
    {
        return $this->getParameter('billingCity');
    }

    public function setCity($value)
    {
        return $this->setParameter('billingCity', $value);
    }

    public function getState()
    {
        return $this->getParameter('billingState');
    }

    public function setState($value)
    {
        return $this->setParameter('billingState', $value);
    }

    public function getBillingPostcode()
    {
        return $this->getParameter('billingPostcode');
    }

    public function setBillingPostcode($value)
    {

        return $this->setParameter('billingPostcode', $value);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

}
