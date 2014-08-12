<?php
namespace Omnipay\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Void Request
 */
class VoidRequest extends AbstractRequest
{
    protected $action = 'Void';

    public function getData()
    {
        $this->validate('transactionId');

        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['TransID'] = $this->getTransactionId();


        return array_merge($data, $this->getBillingData());
    }
}
