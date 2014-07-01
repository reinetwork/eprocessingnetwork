<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Void Request
 */
class VoidRequest extends AbstractRequest
{
    protected $action = 'Void';

    public function getData()
    {
        $this->validate('card');
        $this->getCard()->validate();

        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['Inv'] = 'report';
        $data['TransID'] = $this->getTransactionId();


        return array_merge($data, $this->getBillingData());
    }
}
