<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Observer{
    
    public function beforeModelSave(Varien_Object $observer){

        /* @var $modelObject Mage_Core_Model_Abstract */
        $modelObject = $observer->getObject();

        /* @var $bridgeObject Hackathon_DerivedAttributes_Bridge_Entity */
        $bridgeObject = new Hackathon_DerivedAttributes_Bridge_Entity($modelObject);

        $modelResource = $modelObject->getResource();

        if($modelResource instanceof Mage_Eav_Model_Entity_Abstract
        && !is_null($bridgeObject)){

            /* @var $ruleModel Hackathon_DerivedAttributes_Model_Rule */
            $ruleModel = Mage::getModel("derivedattributes/rule");
            
            /* @var $ruleCollection Hackathon_DerivedAttributes_Model_Resource_Rule_Collection */
            $ruleCollection = $ruleModel->getCollection();

            $serviceManager = new \Hackathon\DerivedAttributes\Service\Manager();
            foreach($modelResource->getAttributesByCode() as $code => $attribute){
                /* @var $attribute Mage_Eav_Model_Entity_Attribute */

                if(!is_null($attribute->getId())){

                    $ruleCollection->resetData();
                    $ruleCollection->addFieldToFilter('attribute_id', $attribute->getId());
                    $ruleCollection->addFieldToFilter('active', "1");

                    $ruleSet = new \Hackathon\DerivedAttributes\RuleSet(
                        new \Hackathon\DerivedAttributes\Attribute($attribute->getAttributeCode()));
                    foreach($ruleCollection->getIterator() as $ruleModel){

                        $ruleSet->addRule(new \Hackathon\DerivedAttributes\Rule($ruleModel, $serviceManager));
                        $ruleSet->applyToEntity($bridgeObject);

                    }

                }
            }
            
        }

    }

}
