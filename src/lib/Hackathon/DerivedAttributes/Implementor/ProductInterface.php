<?php
namespace Hackathon\DerivedAttributes\Implementor;

use Hackathon\DerivedAttributes\Attribute;

/**
 * Interface ProductInterface
 * @package Hackathon\DerivedAttributes\Implementor
 */
interface ProductInterface
{
    const __CLASS = __CLASS__;
    /**
     * @return boolean
     */
    function isChanged();

    /**
     * @param Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(Attribute $attribute);

    /**
     * @param Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(Attribute $attribute);

    /**
     * @param Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(Attribute $attribute, $value);
}