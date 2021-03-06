<?php
namespace Omnipay\eProcessingNetwork;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\GatewayInterface;

class Gateway extends AbstractGateway implements GatewayInterface
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
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\PurchaseRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\VoidRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\RefundRequest', $parameters);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\CreateCardRequest', $parameters);
    }

    public function chargeStoredCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\eProcessingNetwork\Message\ChargeStoredCardRequest', $parameters);
    }

    public function removeAuthorizedTransaction(array $parameters = array())
    {
        return $this->createRequest(
            '\Omnipay\eProcessingNetwork\Message\RemoveAuthorizedRequest',
            $parameters
        );
    }

    /**
     * Alias to match Omnipay docs.
     *
     * @param $value
     * @return $this
     */
    public function setUsername($value)
    {
        return $this->setApiLoginId($value);
    }

    /**
     * Alias to match Omnipay docs.
     *
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setApiRestrictKey($value);
    }

    /**
     * Configure the default client with custom values.
     *
     * CURLOPT_TIMEOUT:        is the maximum amount of time in seconds
     *                         that cURL is allowed to use for connection, including connection
     *                         and transfer
     * CURLOPT_CONNECTTIMEOUT: is the maximum amount of time in seconds
     *                         that is allowed to make the connection to the server.
     */
    protected function getDefaultHttpClient()
    {
        $client = parent::getDefaultHttpClient();
        $client->setConfig([
            'curl.options' => [
                CURLOPT_TIMEOUT        => 360,
                CURLOPT_CONNECTTIMEOUT => 180,
            ],
        ]);

        return $client;
    }
}
