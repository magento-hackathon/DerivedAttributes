<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\Rule;

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
            
            /* @var $serviceManager Manager */
            $serviceManager = Mage::getSingleton("derivedattributes/manager")->getRuleManager();

            foreach($modelResource->getAttributesByCode() as $code => $attribute){
                /* @var $attribute Mage_Eav_Model_Entity_Attribute */

                if(!is_null($attribute->getId())){

                    /* @var $ruleCollection Hackathon_DerivedAttributes_Model_Resource_Rule_Collection */
                    $ruleCollection = $ruleModel->getCollection();
                    $ruleCollection->addFieldToFilter('attribute_id', $attribute->getId());
                    $ruleCollection->addFieldToFilter('active', "1");

                    $ruleSet = new RuleSet(new Attribute($attribute->getAttributeCode()));
                    foreach($ruleCollection->getIterator() as $ruleModel){
                        $ruleSet->addRule(new Rule($ruleModel, $serviceManager));

                    }
                    $ruleSet->applyToEntity($bridgeObject);
                }
            }
            
        }

    }

}
