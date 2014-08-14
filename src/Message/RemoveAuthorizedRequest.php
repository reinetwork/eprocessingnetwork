<?php
namespace Omnipay\eProcessingNetwork\Message;

/**
 * Removes an authorization only transaction from the database if you
 * decide not to capture it. Use the TransID returned in the original
 * authorization.
 *
 */
class RemoveAuthorizedRequest extends AbstractRequest
{
    protected $action = 'AuthDel';

    public function getData()
    {
        $this->validate('transactionId');
        $data = $this->getBaseData();
        $data['TranType'] = $this->action;
        $data['TransID'] = $this->getTransactionId();


        return array_merge($data);
    }
}
