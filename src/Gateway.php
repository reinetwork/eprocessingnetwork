<?php
namespace REINetwork\eProcessingNetwork;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'eProcessing Network';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiLoginId' => '',
            'transactionKey' => '',
            'testMode' => false,
            'developerMode' => false,
        );
    }

    public function getApiLoginId()
    {
        return $this->getParameter('apiLoginId');
    }

    public function setApiLoginId($value)
    {
        return $this->setParameter('apiLoginId', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\REINetwork\eProcessingNetwork\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\REINetwork\eProcessingNetwork\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\REINetwork\eProcessingNetwork\Message\PurchaseRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\REINetwork\eProcessingNetwork\Message\VoidRequest', $parameters);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\REINetwork\eProcessingNetwork\Message\CreateCardRequest', $parameters);
    }
}
