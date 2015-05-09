<?php

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;

/**
 * Product-entity implementation of entity-bridge-interface.
 */
class Hackathon_DerivedAttributes_Bridge_Entity_Product implements \Hackathon\DerivedAttributes\BridgeInterface\EntityInterface
{
    /**
     * @var Mage_Catalog_Model_Product
     */
    private $product;

    function __construct(Mage_Catalog_Model_Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return boolean
     */
    function isChanged()
    {
        return $this->product->hasDataChanges();
    }

    /**
     * @param \Hackathon\DerivedAttributes\Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(\Hackathon\DerivedAttributes\Attribute $attribute)
    {
        return $this->product->getData($attribute->getAttributeCode());
    }

    /**
     * @param \Hackathon\DerivedAttributes\Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(\Hackathon\DerivedAttributes\Attribute $attribute)
    {
        return $this->product->getAttributeText($attribute->getAttributeCode());
    }

    /**
     * @param \Hackathon\DerivedAttributes\Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(\Hackathon\DerivedAttributes\Attribute $attribute, $value)
    {
        $this->product->setData($attribute->getAttributeCode(), $value);
    }

}
