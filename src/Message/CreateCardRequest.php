<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Store Card Request
 */
class CreateCardRequest extends AbstractRequest
{
    protected $action = 'Store';

    public function getData()
    {
        $this->validate('card');
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
