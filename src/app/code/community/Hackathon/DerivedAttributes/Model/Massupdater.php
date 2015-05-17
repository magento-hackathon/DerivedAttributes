<?php
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
    public function update($entityIds, $entityType, $isDryRun)
    {
        $updater = Mage::helper('derivedattributes')->getUpdater();
        $updater->setDryRun($isDryRun);
        $entityTypeInstance = Mage::getModel('eav/entity_type')->loadByCode($entityType);
        if (! $entityTypeInstance->getId()) {
            Mage::throwException(Mage::helper('derivedattributes')->__('Invalid entity type %s.', $entityType));
        }
        /** @var Mage_Core_Model_Abstract $entity */
        $entity = Mage::getModel($entityTypeInstance->getEntityModel());
        /** @var Mage_Eav_Model_Entity_Collection_Abstract $collection */
        $collection = $entity->getCollection();
        $collection->addFieldToFilter('entity_id', ['in' => $entityIds]);
        $entityModel = new Hackathon_DerivedAttributes_Bridge_Entity($entity);
        $iterator = new Hackathon_DerivedAttributes_Bridge_EntityIterator($collection);
        $updater->massUpdate($iterator, $entityModel);
    }
}