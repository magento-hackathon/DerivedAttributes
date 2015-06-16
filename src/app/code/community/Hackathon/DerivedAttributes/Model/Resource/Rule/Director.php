<?php
use Hackathon\DerivedAttributes\Attribute;

class Hackathon_DerivedAttributes_Model_Resource_Rule_Director
{
    public function createRule(Varien_Object $ruleData)
    {
        $builder = Mage::helper('derivedattributes')->getNewRuleBuilder();
        $builder->setPriority((int)$ruleData->getPriority())
            ->setAttribute($this->getAttributeById($ruleData->getData('attribute_id')))
            ->buildCondition($ruleData->getData('condition_type'), $ruleData->getData('condition_data'))
            ->buildGenerator($ruleData->getData('generator_type'), $ruleData->getData('generator_data'));
        return $builder->build();
    }
    /**
     * Returns the Attribute instance
     *
     * @return Attribute
     */
    private function getAttributeById($attributeId){

        /* @var $magentoAttribute Mage_Eav_Model_Entity_Attribute */
        $magentoAttribute = Mage::getModel("eav/entity_attribute")->load($attributeId);

        $attributeCode = $magentoAttribute->getAttributeCode();

        $attribute = new Attribute($attributeCode);

        return $attribute;
    }

}