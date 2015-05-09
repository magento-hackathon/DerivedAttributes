<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Customer-entity implementation of entity-bridge-interface.
 */
class Hackathon_DerivedAttributes_Bridge_Entity_Customer implements EntityInterface
{
    
    private $customer;

    public function __construct(Mage_Customer_Model_Customer $customer){
        $this->customer = $customer;
    }
    
    /**
     * @return boolean
     */
    function isChanged()
    {
        return $this->customer->hasDataChanges();
    }

    /**
     * @param Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(Attribute $attribute)
    {
        return $this->customer->getData($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(Attribute $attribute)
    {
        return $this->customer->getAttributeText($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(Attribute $attribute, $value)
    {
        $this->customer->setData($attribute->getAttributeCode(), $value);
    }
    
}
