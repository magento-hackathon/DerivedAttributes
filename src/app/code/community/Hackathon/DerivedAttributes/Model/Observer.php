<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Store;

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Observer
{
    /**
     * @see event before_model_save
     * @param Varien_Object $observer
     * @throws Mage_Core_Exception
     */
    public function beforeModelSave(Varien_Object $observer)
    {
        $helper = Mage::helper('derivedattributes');
        /* @var $modelObject Mage_Core_Model_Abstract */
        $modelObject = $observer->getObject();
        $modelResource = $modelObject->getResource();

        if($modelResource instanceof Mage_Eav_Model_Entity_Abstract){
            /* @var $bridgeObject Hackathon_DerivedAttributes_Model_Bridge_Entity */
            $bridgeObject = $helper->getNewEntityModel($modelResource->getEntityType(), $modelObject);

            $updater = $helper->getNewUpdater();
            $updater->update($bridgeObject, new Store($modelObject->getStoreId()));
        }

    }

}
