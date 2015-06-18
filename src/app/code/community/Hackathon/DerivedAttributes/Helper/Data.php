<?php
/**
 * This file is part of Hackathon_DerivedAttributes for Magento.
 *
 * @license OSL-3.0
 * @author Fabian Schmengler <fs@integer-net.de> <@fschmengler>
 * @category Hackathon
 * @package Hackathon_DerivedAttributes
 */

use Hackathon\DerivedAttributes\Updater;
use Hackathon\DerivedAttributes\RuleBuilder;
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\StoreSet;

/**
 * Data Helper
 * @package Hackathon_DerivedAttributes
 */
class Hackathon_DerivedAttributes_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return \Hackathon\DerivedAttributes\Service\Manager
     */
    public function getServiceManager()
    {
        return Mage::getSingleton('derivedattributes/manager')->getRuleManager();
    }

    /**
     * Factory method for Updater
     *
     * @return Updater
     */
    public function getNewUpdater()
    {
        $ruleRepository = Mage::getModel('derivedattributes/bridge_ruleRepository');
        $ruleLogger = Mage::getModel('derivedattributes/bridge_ruleLogger');

        return new Updater($ruleRepository, $ruleLogger);
    }

    /**
     * @return RuleBuilder
     */
    public function getNewRuleBuilder(Attribute $attribute)
    {
        return new RuleBuilder($this->getServiceManager(), $attribute);
    }

    /**
     * @param Mage_Eav_Model_Entity_Type $entityTypeInstance
     * @return Hackathon_DerivedAttributes_Model_Bridge_EntityIterator
     */
    public function getNewEntityIterator(Mage_Eav_Model_Entity_Type $entityTypeInstance, $entityIds)
    {
        /** @var Mage_Eav_Model_Entity_Collection_Abstract $collection */
        $collection = Mage::getModel($entityTypeInstance->getEntityModel())->getCollection();
        $collection->addFieldToFilter('entity_id', ['in' => $entityIds]);
        /*
         * I tried using the flat catalog if available but using it from admin area is not intended
         * and there are too many restrictions and special cases
         */
        $collection->addAttributeToSelect('*');

        $iterator = new Hackathon_DerivedAttributes_Model_Bridge_EntityIterator($collection);
        return $iterator;
    }

    /**
     * @param Mage_Eav_Model_Entity_Type $entityTypeInstance
     * @return Hackathon_DerivedAttributes_Model_Bridge_Entity
     */
    public function getNewEntityModel(Mage_Eav_Model_Entity_Type $entityTypeInstance, Mage_Core_Model_Abstract $entity = null)
    {
        if ($entity === null) {
            $entity = Mage::getModel($entityTypeInstance->getEntityModel());
        }
        $entityModel = new Hackathon_DerivedAttributes_Model_Bridge_Entity($entityTypeInstance, $entity);
        return $entityModel;
    }

    /**
     * @param $storeIds
     * @param bool $expand Set to true if ['0'] should be expanded to all store views
     * @return StoreSet
     */
    public function createStoreSet($storeIds, $expand = false)
    {
        //TODO make consistent. ATM data from form or loaded rule model is prepared as array, from collection not
        if (! is_array($storeIds)) {
            $storeIds = explode(',', $storeIds);
        }
        if ($storeIds === ['0']) {
            if (! $expand) {
                return StoreSet::all();
            }
            $storeIds = array_keys(Mage::app()->getStores(true));
        }
        return new StoreSet($storeIds);
    }

    /**
     * @param $entityType
     * @return Mage_Eav_Model_Entity_Type
     * @throws Mage_Core_Exception
     */
    public function getEntityTypeInstance($entityType)
    {
        $entityTypeInstance = Mage::getModel('eav/entity_type')->loadByCode($entityType);
        if (!$entityTypeInstance->getId()) {
            Mage::throwException(Mage::helper('derivedattributes')->__('Invalid entity type %s.', $entityType));
            return $entityTypeInstance;
        }
        return $entityTypeInstance;
    }
}