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
        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['TransID'] = $this->getTransactionId();


        return array_merge($data);
    }
}
