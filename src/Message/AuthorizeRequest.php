<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    const TRANSACTION_TYPE = 'AuthOnly';

    protected $action = 'AUTH_ONLY';


    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();

        $data = $this->getBaseData();
        $data['TranType'] = self::TRANSACTION_TYPE;
        $data['CardNo'] = $this->getCard()->getNumber();
        $data['ExpMonth'] = $this->getCard()->getExpiryMonth();
        $data['ExpYear'] = $this->getCard()->getExpiryYear();
        $data['CVV2'] = $this->getCard()->getCvv();

        return array_merge($data, $this->getBillingData());
    }
}
