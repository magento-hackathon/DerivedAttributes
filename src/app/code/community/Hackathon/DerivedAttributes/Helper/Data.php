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
    public function getNewUpdater($storeId = null)
    {
        $ruleRepository = Mage::getResourceModel('derivedattributes/rule');
        if ($storeId !== null) {
            $ruleRepository->setStoreFilter($storeId);
        }
        $ruleLogger = new Hackathon_DerivedAttributes_Bridge_RuleLogger();

        return new Updater($ruleRepository, $ruleLogger);
    }

    /**
     * @return \Hackathon\DerivedAttributes\Service\Manager
     */
    public function getServiceManager()
    {
        return Mage::getSingleton('derivedattributes/manager')->getRuleManager();
    }

    /**
     * @return RuleBuilder
     */
    public function getNewRuleBuilder(Attribute $attribute)
    {
        return new RuleBuilder($this->getServiceManager(), $attribute);
    }
}