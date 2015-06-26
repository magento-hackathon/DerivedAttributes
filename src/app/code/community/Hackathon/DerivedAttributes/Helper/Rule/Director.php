<?php
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\StoreSet;

/**
 * Director to instantiate Rule based on raw data
 */
class Hackathon_DerivedAttributes_Helper_Rule_Director
{
    public function createRule(Varien_Object $ruleData)
    {
        $helper = Mage::helper('derivedattributes');
        $builder = $helper->getNewRuleBuilder($this->getAttributeById($ruleData->getData('attribute_id')));
        $builder->setActive((bool) $ruleData->getData('active'))
            ->setPriority((int) $ruleData->getData('priority'))
            ->setConditionType($ruleData->getData('condition_type'))
            ->setConditionData($ruleData->getData('condition_data'))
            ->setGeneratorType($ruleData->getData('generator_type'))
            ->setGeneratorData($ruleData->getData('generator_data'))
            ->setName($ruleData->getData('name'))
            ->setDescription($ruleData->getData('description'))
            ->setStores($helper->createStoreSet($ruleData->getData('store_id')));
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

        $attribute = new Attribute($magentoAttribute->getEntityType()->getEntityTypeCode(), $magentoAttribute->getAttributeCode());

        return $attribute;
    }

}