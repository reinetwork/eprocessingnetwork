<?php
namespace REINetwork\eProcessingNetwork\Message;

/**
 * eProcessingNetwork Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    protected $action = 'AUTH_CAPTURE';
}
