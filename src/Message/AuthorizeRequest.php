<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $action = 'AuthOnly';

    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();

        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['CardNo'] = $this->getCard()->getNumber();
        $data['ExpMonth'] = $this->getCard()->getExpiryMonth();
        $data['ExpYear'] = $this->getCard()->getExpiryYear();
        $data['CVV2'] = $this->getCard()->getCvv();

        return array_merge($data, $this->getBillingData());
    }
}
