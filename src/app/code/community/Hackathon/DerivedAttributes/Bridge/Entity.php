<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Entity implementation of entity-bridge-interface.
 */
class Hackathon_DerivedAttributes_Bridge_Entity implements \Hackathon\DerivedAttributes\BridgeInterface\EntityInterface
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    private $entity;

    function __construct(Mage_Core_Model_Abstract $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return boolean
     */
    function isChanged()
    {
        return $this->entity->hasDataChanges();
    }

    /**
     * @param Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(Attribute $attribute)
    {
        return $this->entity->getData($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(Attribute $attribute)
    {
        return $this->entity->getAttributeText($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(Attribute $attribute, $value)
    {
        $this->entity->setData($attribute->getAttributeCode(), $value);
    }

}
