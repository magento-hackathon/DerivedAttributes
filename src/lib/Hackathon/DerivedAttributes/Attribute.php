<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace Hackathon\DerivedAttributes;


class Attribute
{
    const __CLASS = __CLASS__;

    protected $attributeCode;

    /**
     * @param string $attributeCode
     */
    function __construct($attributeCode)
    {
        $this->attributeCode = (string) $attributeCode;
    }

    /**
     * @return string
     */
    public function getAttributeCode()
    {
        return $this->attributeCode;
    }

}