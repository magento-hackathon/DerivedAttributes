<?php
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\StoreSet;

class Hackathon_DerivedAttributes_Model_Resource_Rule_Director
{
    public function createRule(Varien_Object $ruleData)
    {
        $builder = Mage::helper('derivedattributes')->getNewRuleBuilder($this->getAttributeById($ruleData->getData('attribute_id')));
        $builder->setActive((bool) $ruleData->getData('active'))
            ->setPriority((int) $ruleData->getData('priority'))
            ->setConditionType($ruleData->getData('condition_type'))
            ->setConditionData($ruleData->getData('condition_data'))
            ->setGeneratorType($ruleData->getData('generator_type'))
            ->setGeneratorData($ruleData->getData('generator_data'))
            ->setName($ruleData->getData('name'))
            ->setDescription($ruleData->getData('description'))
            ->setStores($this->getStoreSet($ruleData->getData('store_id')));
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

    private function getStoreSet($storeIds)
    {
        //TODO make consistent. ATM data from form or loaded rule model is prepared as array, from collection not
        if (! is_array($storeIds)) {
            $storeIds = explode(',', $storeIds);
        }
        if ($storeIds === ['0']) {
            return StoreSet::all();
        }
        return new StoreSet($storeIds);
    }
}