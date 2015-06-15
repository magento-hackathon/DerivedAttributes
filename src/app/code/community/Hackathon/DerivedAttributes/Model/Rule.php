<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Bridge-entity for rule(s).
 */
class Hackathon_DerivedAttributes_Model_Rule
    extends Mage_Core_Model_Abstract 
    implements RuleInterface {
    
    protected function _construct(){
        $this->_init("derivedattributes/rule");
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
     * Return rule priority (higher number = more priority)
     *
     * @return int
     */
    function getPriority(){
        return (int)$this->getData("priority");
    }

    protected function _beforeSave()
    {
        $this->setStoreId(join(',', (array)$this->getStoreId()));
        return parent::_beforeSave();
    }

    protected function _afterLoad()
    {
        $this->setStoreId(explode(',', $this->getStoreId()));
        return parent::_afterLoad();
    }

    /**
     * Return the Condition type
     *
     * @return string
     */
    function getConditionType()
    {
        return $this->getData('condition_type');
    }

    /**
     * Return information for instantiating the condition
     *
     * @return string
     */
    function getConditionData()
    {
        return $this->getData('condition_data');
    }

}
