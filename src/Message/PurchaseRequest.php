<?php
namespace Omnipay\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    protected $action = 'Sale';
}
