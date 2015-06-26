<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace Hackathon\DerivedAttributes;

/**
 * Attribute: Value object, representing a Magento attribute code
 *
 * @package Hackathon\DerivedAttributes
 */
class Attribute
{

    protected $entityTypeCode;
    protected $attributeCode;

    /**
     * @param string $entityTypeCode
     * @param string $attributeCode
     */
    function __construct($entityTypeCode, $attributeCode)
    {
        $this->entityTypeCode = (string) $entityTypeCode;
        $this->attributeCode = (string) $attributeCode;
    }

    /**
     * @return string
     */
    public function getAttributeCode()
    {
        return $this->attributeCode;
    }

    /**
     * @return string
     */
    public function getEntityTypeCode()
    {
        return $this->entityTypeCode;
    }

}