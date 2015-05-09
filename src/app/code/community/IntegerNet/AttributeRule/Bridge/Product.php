<?php

class IntegerNet_AttributeRule_Bridge_Product implements \IntegerNet\AttributeRule\Implementor\ProductInterface
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
     * @param \IntegerNet\AttributeRule\Attribute $attribute
     * @return mixed
     */
    function getAttributeValue(\IntegerNet\AttributeRule\Attribute $attribute)
    {
        return $this->product->getData($attribute->getAttributeCode());
    }

    /**
     * @param \IntegerNet\AttributeRule\Attribute $attribute
     * @return string
     */
    function getLocalizedAttributeValue(\IntegerNet\AttributeRule\Attribute $attribute)
    {
        return $this->product->getAttributeText($attribute->getAttributeCode());
    }

    /**
     * @param \IntegerNet\AttributeRule\Attribute $attribute
     * @param mixed $value
     * @return void
     */
    function setAttributeValue(\IntegerNet\AttributeRule\Attribute $attribute, $value)
    {
        $this->product->setData($attribute->getAttributeCode(), $value);
    }

}