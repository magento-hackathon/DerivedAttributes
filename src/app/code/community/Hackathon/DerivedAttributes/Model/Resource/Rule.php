<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleRepositoryInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\RuleBuilder;
use Hackathon\DerivedAttributes\Rule;
use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\StoreSet;

/**
 * Resource model / Rule repository
 *
 * @todo split repository from Magento resource model
 */
class Hackathon_DerivedAttributes_Model_Resource_Rule 
    extends Mage_Core_Model_Resource_Db_Abstract
    implements RuleRepositoryInterface
{
    /**
     * @var Hackathon_DerivedAttributes_Model_Resource_Rule_Collection
     */
    protected $_ruleCollection;
    /**
     * @var SplObjectStorage
     */
    protected $_ruleStorage;

    protected function _construct(){
        $this->_init("derivedattributes/rule", "rule_id");
        $this->_ruleStorage = new SplObjectStorage();
    }

    public function getRuleId(Rule $rule)
    {
        if ($this->_ruleStorage->contains($rule)) {
            return $this->_ruleStorage[$rule];
        }
        return null;
    }
    /**
     * @return RuleSet
     */
    public function findActive()
    {
        /* @var $serviceManager Manager */
        $serviceManager = Mage::getSingleton("derivedattributes/manager")->getRuleManager();

        $this->getRuleCollection()->addFieldToFilter('active', "1");


        $ruleSet = new RuleSet();
        $ruleDirector = Mage::getResourceSingleton('derivedattributes/rule_director');
        foreach($this->getRuleCollection() as $ruleData) {
            $rule = $ruleDirector->createRule($ruleData);
            $this->_registerRule($ruleData->getId(), $rule);
            $ruleSet->addRule($rule);
        }
        return $ruleSet;
    }

    public function findById($ruleId)
    {
        $model = Mage::getModel(Hackathon_DerivedAttributes_Model_Rule::ALIAS)->load($ruleId);
        if (! $model->getId()) {
            Mage::throwException(Mage::helper('derivedattributes')->__('Rule not found'));
        }
        $ruleDirector = Mage::getResourceSingleton('derivedattributes/rule_director');
        $rule = $ruleDirector->createRule($model);
        $this->_registerRule($ruleId, $rule);
        return $rule;
    }

    /**
     * @param \Hackathon\DerivedAttributes\Rule $newRule
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

    public function setStoreFilter($storeId)
    {
        # ... WHERE store_id IS NULL OR FIND_IN_SET(:storeId, store_id)
        $this->getRuleCollection()->addFieldToFilter('store_id', [
            ['eq'   => '0'],
            ['finset' => [$storeId]]
        ]);
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

    public function getRuleCollection()
    {
        if ($this->_ruleCollection === null) {
            $this->_ruleCollection = Mage::getResourceModel('derivedattributes/rule_collection');
        }
        return $this->_ruleCollection;
    }

    /**
     * Returns Magento attrribute id based on Attribute instance
     *
     * @return Attribute
     */
    private static function getAttributeId(Attribute $attribute)
    {
        //TODO determine entity type by $attribute
        //TODO write test for conflicting attribute code
        /* @var $magentoAttribute Mage_Eav_Model_Entity_Attribute */
        $magentoAttribute = Mage::getModel("eav/entity_attribute")
            ->loadByCode('catalog_product', $attribute->getAttributeCode());

        return $magentoAttribute->getId();
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
}