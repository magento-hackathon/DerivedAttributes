<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleRepositoryInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\RuleBuilder;

    /**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Resource_Rule 
    extends Mage_Core_Model_Resource_Db_Abstract
    implements RuleRepositoryInterface
{
    /**
     * @var Hackathon_DerivedAttributes_Model_Resource_Rule_Collection
     */
    protected $_ruleCollection;

    protected function _construct(){
        $this->_init("derivedattributes/rule", "rule_id");
    }

    function findActive()
    {
        /* @var $serviceManager Manager */
        $serviceManager = Mage::getSingleton("derivedattributes/manager")->getRuleManager();

        $this->getRuleCollection()->addFieldToFilter('active', "1");


        $ruleSet = new RuleSet();
        $ruleDirector = Mage::getResourceSingleton('derivedattributes/rule_director');
        foreach($this->getRuleCollection() as $ruleData) {
            $ruleSet->addRule($ruleDirector->createRule($ruleData));
        }
        return $ruleSet;
    }

    public function setStoreFilter($storeId)
    {
        # ... WHERE store_id IS NULL OR FIND_IN_SET(:storeId, store_id)
        $this->getRuleCollection()->addFieldToFilter('store_id', [
            ['eq'   => '0'],
            ['finset' => [$storeId]]
        ]);
    }

    public function getRuleCollection()
    {
        if ($this->_ruleCollection === null) {
            $this->_ruleCollection = Mage::getResourceModel('derivedattributes/rule_collection');
        }
        return $this->_ruleCollection;
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $object->setStoreId(explode(',', $object->getStoreId()));
        return parent::_afterLoad($object);
    }


    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $object->setStoreId(join(',', (array)$object->getStoreId()));
        return parent::_beforeSave($object);
    }

}