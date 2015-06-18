<?php

class Hackathon_DerivedAttributes_Model_Massupdater
{
    /**
     * Trigger updater for given entities in given store ids
     *
     * @param string[] $entityIds
     * @param string   $entityType
     * @param string[] $storeIds
     * @param bool     $isDryRun
     */
    public function update($entityIds, $entityType, $storeIds, $isDryRun)
    {
        $helper = Mage::helper('derivedattributes');
        $entityTypeInstance = $helper->getEntityTypeInstance($entityType);

        $updater = $helper->getNewUpdater();
        $updater->setDryRun($isDryRun);
        $updater->massUpdate(
            $helper->getNewEntityIterator($entityTypeInstance, $entityIds),
            $helper->getNewEntityModel($entityTypeInstance),
            $helper->createStoreSet($storeIds, true));
    }

}