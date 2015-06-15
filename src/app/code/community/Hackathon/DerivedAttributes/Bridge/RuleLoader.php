<?php
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoaderInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\Rule;
use Hackathon\DerivedAttributes\RuleBuilder;

class Hackathon_DerivedAttributes_Bridge_RuleLoader implements RuleLoaderInterface
{
    /**
     * @var Hackathon_DerivedAttributes_Model_Resource_Rule_Collection
     */
    protected $_ruleCollection;

    public function getRuleCollection()
    {
        if ($this->_ruleCollection === null) {
            $this->_ruleCollection = Mage::getResourceModel('derivedattributes/rule_collection');
        }
        return $this->_ruleCollection;
    }
    public function setStoreFilter($storeId)
    {
        # ... WHERE store_id IS NULL OR FIND_IN_SET(:storeId, store_id)
        $this->getRuleCollection()->addFieldToFilter('store_id', [
            ['eq'   => '0'],
            ['finset' => [$storeId]]
        ]);
    }
    /**
     * @return \Hackathon\DerivedAttributes\RuleSet
     */
    public function getRuleset()
    {
        /* @var $serviceManager Manager */
        $serviceManager = Mage::getSingleton("derivedattributes/manager")->getRuleManager();

        $this->getRuleCollection()->addFieldToFilter('active', "1");


        $ruleSet = new RuleSet();
        foreach($this->getRuleCollection() as $ruleModel){
            /* @var $ruleModel Hackathon_DerivedAttributes_Model_Rule */
            $builder = new RuleBuilder($ruleModel, $serviceManager);
            $ruleSet->addRule($builder->build($ruleModel, $serviceManager));
        }
        return $ruleSet;
    }

}