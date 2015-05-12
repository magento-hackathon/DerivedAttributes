<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Updater;

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

            $ruleLoader = new Hackathon_DerivedAttributes_Bridge_RuleLoader();
            $ruleLoader->setStoreFilter($modelObject->getStoreId());

            $updater = new Updater($ruleLoader);
            $updater->update($bridgeObject);
        }

    }

}
