<?php

/**
 * @todo move store logic to actual updater, instantiation into factory methods
 */
class Hackathon_DerivedAttributes_Model_Massupdater
{
    /**
     * Trigger updater for given entities
     *
     * @param $entityIds
     * @param $entityType
     * @param $isDryRun
     * @throws Mage_Core_Exception
     */
    public function update($entityIds, $entityType, $storeIds, $isDryRun)
    {
        foreach ($storeIds as $storeId) {
            $this->_updateStore($entityIds, $entityType, $storeId, $isDryRun);
        }
    }

    /**
     * Trigger updater for single scope (storeId=0 for default scope)
     *
     * @param $entityIds
     * @param $entityType
     * @param $storeId
     * @param $isDryRun
     * @throws Mage_Core_Exception
     */
    protected function _updateStore($entityIds, $entityType, $storeId, $isDryRun)
    {
        $updater = Mage::helper('derivedattributes')->getNewUpdater($storeId);
        $updater->setDryRun($isDryRun);
        $entityTypeInstance = Mage::getModel('eav/entity_type')->loadByCode($entityType);
        if (! $entityTypeInstance->getId()) {
            Mage::throwException(Mage::helper('derivedattributes')->__('Invalid entity type %s.', $entityType));
        }
        /** @var Mage_Core_Model_Abstract $entity */
        $entity = Mage::getModel($entityTypeInstance->getEntityModel());
        /** @var Mage_Eav_Model_Entity_Collection_Abstract $collection */
        $collection = $entity->getCollection();
        $collection->setStoreId($storeId);
        $collection->addFieldToFilter('entity_id', ['in' => $entityIds]);

        /*
         * I tried using the flat catalog if available but using it from admin area is not intended
         * and there are too many restrictions and special cases
         */
        $collection->addAttributeToSelect('*');

        $entityModel = new Hackathon_DerivedAttributes_Model_Bridge_Entity($entityTypeInstance, $entity);
        $iterator = new Hackathon_DerivedAttributes_Model_Bridge_EntityIterator($collection, $storeId);

        $updater->massUpdate($iterator, $entityModel);
    }
}