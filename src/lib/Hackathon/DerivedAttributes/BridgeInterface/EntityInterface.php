<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Attribute;

/**
 * Interface EntityInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface EntityInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * Returns true iff attributes have changed
     *
     * @return boolean
     */
    function isChanged();

    /**
     * Returns true if entity has this kind of attribute
     *
     * @param Attribute $attribute
     * @return bool
     */
    function hasAttribute(Attribute $attribute);

    /**
     * Returns raw attribute value
     *
     * @param Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(Attribute $attribute);

    /**
     * Returns attribute value localized for current store
     *
     * @param Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(Attribute $attribute);

    /**
     * Sets attribute value
     *
     * @param Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(Attribute $attribute, $value);

    /**
     * Sets raw data from database
     *
     * @param string[] $data
     * @return void
     */
    function setRawData($data);

    /**
     * Save changed attribute values in database
     *
     * @return void
     */
    function saveAttributes();

    /**
     * Reset to empty instance
     *
     * @return void
     */
    function clearInstance();
}