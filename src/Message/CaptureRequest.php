<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    protected $action = 'Auth2Sale';

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
