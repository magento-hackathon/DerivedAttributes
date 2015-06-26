<?php
use Hackathon\DerivedAttributes\BridgeInterface\RuleRepositoryInterface;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\Rule;
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\StoreSet;
use Hackathon\DerivedAttributes\RuleSetsByStore;
use Hackathon\DerivedAttributes\Store;

class Hackathon_DerivedAttributes_Model_Bridge_RuleRepository implements RuleRepositoryInterface
{
    /**
     * @var SplObjectStorage
     */
    protected $_ruleStorage;

    public function __construct(){
        $this->_ruleStorage = new SplObjectStorage();
    }

    public function getRuleId(Rule $rule)
    {
        if ($this->_ruleStorage->contains($rule)) {
            return $this->_ruleStorage[$rule];
        }
        return null;
    }

    public function findById($ruleId)
    {
        $model = Mage::getModel(Hackathon_DerivedAttributes_Model_Rule::ALIAS)->load($ruleId);
        if (! $model->getId()) {
            Mage::throwException(Mage::helper('derivedattributes')->__('Rule not found'));
        }
        $ruleDirector = Mage::helper('derivedattributes/rule_director');
        $rule = $ruleDirector->createRule($model);
        $this->_registerRule($ruleId, $rule);
        return $rule;
    }

    /**
     * Returns rule set with all active rules
     *
     * @return \Hackathon\DerivedAttributes\RuleSet
     */
    public function findRuleSetsForStores(StoreSet $stores)
    {
        $ruleSetsByStore = new RuleSetsByStore();
        foreach ($stores as $store) {
            $ruleSetsByStore->addRuleSet($this->findRuleSetForStore($store), $store);
        }
        return $ruleSetsByStore;
    }
    private function findRuleSetForStore(Store $store)
    {
        $collection = $this->getRuleCollection();
        # ... WHERE store_id IS NULL OR FIND_IN_SET(:storeId, store_id)
        $collection->addFieldToFilter('store_id', [
            ['eq'   => '0'],
            ['finset' => [(string) $store]]
        ]);
        $collection->addFieldToFilter('active', "1");

        $ruleSet = new RuleSet();
        $ruleDirector = Mage::helper('derivedattributes/rule_director');
        foreach($collection as $ruleData) {
            $rule = $ruleDirector->createRule($ruleData);
            $this->_registerRule($ruleData->getId(), $rule);
            $ruleSet->addRule($rule);
        }
        return $ruleSet;
    }

    /**
     * @param Rule $newRule
     * @return void
     */
    public function createRule(Rule $newRule)
    {
        $model = $this->getRuleModel($newRule);
        $model->save();
        $this->_registerRule($model->getId(), $newRule);
    }

    /**
     * @param Rule $oldRule
     * @param Rule $newRule
     * @return void
     */
    function replaceRule(Rule $oldRule, Rule $newRule)
    {
        $model = $this->getRuleModel($newRule);
        $model->setId($this->getRuleId($oldRule));
        $model->save();
        $this->_unregisterRule($oldRule);
        $this->_registerRule($model->getId(), $newRule);
    }

    /**
     * @param Rule $ruleToBeDeleted
     * @return void
     */
    public function deleteRule(Rule $ruleToBeDeleted)
    {
        $this->getRuleModel($ruleToBeDeleted)->delete();
        $this->_unregisterRule($ruleToBeDeleted);
    }

    /**
     * Registers Rule with ID for database mapping
     *
     * @param int $ruleId
     * @param Rule $rule
     * @return $this
     */
    protected function _registerRule($ruleId, Rule $rule)
    {
        $this->_ruleStorage->attach($rule, $ruleId);
        return $this;
    }

    /**
     * Unregisters removed/replace Rule for database mapping
     *
     * @param Rule $rule
     * @return $this
     */
    protected function _unregisterRule(Rule $rule)
    {
        $this->_ruleStorage->detach($rule);
        return $this;
    }

    /**
     * @return Hackathon_DerivedAttributes_Model_Resource_Rule_Collection
     */
    private function getRuleCollection()
    {
        return Mage::getResourceModel('derivedattributes/rule_collection');
    }

    public function getRuleModel(Rule $rule)
    {
        $manager = Mage::helper('derivedattributes')->getServiceManager();
        /** @var Hackathon_DerivedAttributes_Model_Rule $model */
        $model = Mage::getModel(Hackathon_DerivedAttributes_Model_Rule::ALIAS);
        $model->setData(array(
                'name'           => $rule->getName(),
                'description'    => $rule->getDescription(),
                'active'         => $rule->isActive(),
                'priority'       => $rule->getPriority(),
                'attribute_id'   => self::getAttributeId($rule->getAttribute()),
                'condition_type' => $manager->getConditionType($rule->getCondition()),
                'condition_data' => $rule->getCondition()->getData(),
                'generator_type' => $manager->getGeneratorType($rule->getGenerator()),
                'generator_data' => $rule->getGenerator()->getData(),
                'store_id'       => $rule->getStores() === StoreSet::all() ? ['0'] : $rule->getStores()->getStoreCodes()
            )
        );
        $model->setId($this->getRuleId($rule));
        return $model;
    }

    /**
     * Returns Magento attrribute id based on Attribute instance
     *
     * @return Attribute
     */
    private static function getAttributeId(Attribute $attribute)
    {
        /* @var $magentoAttribute Mage_Eav_Model_Entity_Attribute */
        $magentoAttribute = Mage::getModel("eav/entity_attribute")
            ->loadByCode($attribute->getEntityTypeCode(), $attribute->getAttributeCode());

        return $magentoAttribute->getId();
    }

}