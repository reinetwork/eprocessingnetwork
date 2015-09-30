<?php namespace Omnipay\eProcessingNetwork\Message;

use Omnipay\Common\CreditCard;

/**
 * eProcessingNetwork Refund Request
 */
class RefundRequest extends AbstractRequest
{
    protected $action = 'Return';

    public function getData()
    {
        $data = $this->getBaseData();
        $data['TranType'] = $this->action;

        if ($this->getParameter('transactionId')) {
            $this->validate('amount', 'transactionId');
            $data['TransID'] = $this->getParameter('transactionId');
        } elseif ($this->getCard() instanceof CreditCard) {
            $this->validate('amount', 'card');
            $this->getCard()->validate();
            $data['CardNo'] = $this->getCard()->getNumber();
            $data['ExpMonth'] = $this->getCard()->getExpiryMonth();
            $data['ExpYear'] = $this->getCard()->getExpiryYear();
            $data['CVV2'] = $this->getCard()->getCvv();
        }

        return array_merge($data, $this->getBillingData());
    }
}
