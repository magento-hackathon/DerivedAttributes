<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Bridge-entity for rule(s).
 */
class Hackathon_DerivedAttributes_Model_Rule 
    extends Mage_Core_Model_Abstract 
    implements RuleInterface{
    
	/**
     * @SuppressWarnings(PHPMD)
	 * @see Varien_Object::_construct()
	 */
    protected function _construct(){
        $this->_init("derivedattributes/rule");
    }

    /**
     * Return generator
     *
     * @return RuleGeneratorInterface
     */
    function getRuleGenerator(){

        $generatorEntity = new Hackathon_DerivedAttributes_Bridge_Generator(
            $this->getGeneratorType(),
            $this->getGeneratorData()
        );
        
        return $generatorEntity;
    }

    /**
     * Returns the Attribute instance
     *
     * @return Attribute
     */
    function getAttribute(){

        $attributeId = $this->getData("attribute_id");
    
        /* @var $magentoAttribute Mage_Eav_Model_Entity_Attribute */
        $magentoAttribute = Mage::getModel("eav/entity_attribute")->load($attributeId);

        $attributeCode = $magentoAttribute->getAttributeCode();

        $attribute = new Attribute($attributeCode);

        return $attribute;
    }

    /**
     * Return the Generator type
     *
     * @return string
     */
    function getGeneratorType(){
        return $this->getData("generator_type");
    }

    /**
     * Return information for instantiating the generator
     *
     * @return string
     */
    function getGeneratorData(){
        return $this->getData("generator_data");
    }

    /**
     * Return condition
     *
     * @return RuleConditionInterface
     */
    function getRuleCondition(){

        $conditionType = $this->getData("condition_type");
        $conditionData = $this->getData("condition_data");

        /* @var $condition Hackathon_DerivedAttributes_Model_Rulecondition */
        $condition = Mage::getModel("derivedattributes/rulecondition");
        $condition->setConditionType($conditionType);
        $condition->setConditionData($conditionData);

        return $condition;
    }

    /**
     * Return sorted array of filters
     *
     * @return RuleFilterInterface[]
     */
    function getRuleFilters(){

        $filters = array();

        /* @var $filterModel Hackathon_DerivedAttributes_Model_Rulefilter */
        $filterModel = Mage::getModel("derivedattributes/rulefilter");

        /* @var $filterCollection Hackathon_DerivedAttributes_Model_Resource_Rulefilter_Collection */
        $filterCollection = $filterModel->getCollection();
    
        foreach($filterCollection->getIterator() as $filterModel){
            $filters[] = $filterModel;
        }

        return $filters;
    }

    /**
     * Return rule priority (higher number = more priority)
     *
     * @return int
     */
    function getPriority(){
        return (int)$this->getData("priority");
    }

}
