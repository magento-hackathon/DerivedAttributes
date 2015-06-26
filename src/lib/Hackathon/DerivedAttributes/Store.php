<?php
namespace Hackathon\DerivedAttributes;

/**
 * Store: Value object, representing a Magento store
 *
 * @package Hackathon\DerivedAttributes
 */
class Store
{
    const __CLASS = __CLASS__;

    private $storeCode;

    public function __construct($storeCode)
    {
        $this->storeCode = (string) $storeCode;
    }
    public function __toString()
    {
        return $this->storeCode;
    }
}