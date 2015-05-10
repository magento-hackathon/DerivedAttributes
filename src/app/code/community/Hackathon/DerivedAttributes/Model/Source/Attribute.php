<?php
class Hackathon_DerivedAttributes_Model_Source_Attribute
{
    public function toOptionArray()
    {
        $options = array();
        /** @var Mage_Catalog_Model_Resource_Product_Attribute_Collection $attributeCollection */
        $attributeCollection = Mage::getResourceModel('catalog/product_attribute_collection');
        $attributeCollection->addVisibleFilter();
        $values = array();
        foreach ($attributeCollection as $attribute) {
            /** @var Mage_Eav_Model_Attribute $attribute */
            $values[] = array(
                'label' =>  $attribute->getFrontendLabel() ?: $attribute->getAttributeCode(),
                'value' => $attribute->getId()
            );
        }
        $options[] = array(
            'label' => 'Product',
            'value' => $values
        );

        /** @var Mage_Customer_Model_Resource_Attribute_Collection $attributeCollection */
        $attributeCollection = Mage::getResourceModel('customer/attribute_collection');
        $attributeCollection->addSystemHiddenFilter();
        $values = array();
        foreach ($attributeCollection as $attribute) {
            /** @var Mage_Eav_Model_Attribute $attribute */
            $values[] = array(
                'label' =>  $attribute->getFrontendLabel() ?: $attribute->getAttributeCode(),
                'value' => $attribute->getId()
            );
        }
        $options[] = array(
            'label' => 'Customer',
            'value' => $values
        );

        return $options;
    }

}