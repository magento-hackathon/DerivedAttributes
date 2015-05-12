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

        $modelResource = $modelObject->getResource();

        if($modelResource instanceof Mage_Eav_Model_Entity_Abstract){
            /* @var $bridgeObject Hackathon_DerivedAttributes_Bridge_Entity */
            $bridgeObject = new Hackathon_DerivedAttributes_Bridge_Entity($modelObject);

            /* @var $serviceManager Manager */
            $serviceManager = Mage::getSingleton("derivedattributes/manager")->getRuleManager();

            /* @var $ruleCollection Hackathon_DerivedAttributes_Model_Resource_Rule_Collection */
            $ruleModel = Mage::getModel("derivedattributes/rule");
            $ruleCollection = Mage::getResourceModel('derivedattributes/rule_collection');
            $ruleCollection->addFieldToFilter('active', "1");

            # ... WHERE store_id IS NULL OR FIND_IN_SET(:storeId, store_id)
            $ruleCollection->addFieldToFilter('store_id', [
                ['eq'   => '0'],
                ['finset' => [$modelObject->getStoreId()]]
            ]);

            $ruleSet = new RuleSet();
            foreach($ruleCollection->getIterator() as $ruleModel){
                /* @var $ruleModel Hackathon_DerivedAttributes_Model_Rule */
                $ruleSet->addRule(new Rule($ruleModel, $serviceManager));
            }
            $ruleSet->applyToEntity($bridgeObject);
        }

    }

}
