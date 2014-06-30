<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    protected $action = 'PRIOR_AUTH_CAPTURE';

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        $data = $this->getBaseData();
        $data['Total'] = $this->getAmount();
        //@todo CHECK THIS: $data['Inv'] = $this->getTransactionReference();

        return $data;
    }
}
