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

/**
 * Data Helper
 * @package Hackathon_DerivedAttributes
 */
class Hackathon_DerivedAttributes_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Factory method for Updater
     *
     * @param int|null $storeId
     * @return Updater
     */
    public function getUpdater($storeId = null)
    {
        $ruleLoader = new Hackathon_DerivedAttributes_Bridge_RuleLoader();
        if ($storeId !== null) {
            $ruleLoader->setStoreFilter($storeId);
        }
        $ruleLogger = new Hackathon_DerivedAttributes_Bridge_RuleLogger();

        return new Updater($ruleLoader, $ruleLogger);
    }
}