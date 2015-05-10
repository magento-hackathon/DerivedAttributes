<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_RuleCondition
    extends Mage_Core_Model_Abstract
    implements RuleConditionInterface{
    
	/**
     * @SuppressWarnings(PHPMD)
	 * @see Varien_Object::_construct()
	 */
    protected function _construct(){
        $this->_init("derivedattributes/rule_condition");
    }

    /**
     * Return the Condition type
     *
     * @return string
     */
    function getConditionType(){
        return $this->getData("condition_type");
    }

    /**
     * Return information for instantiating the condition
     *
     * @return string
     */
    function getConditionData(){
        return $this->getData("condition_data");
    }

    /**
     * @return RuleConditionInterface[]
     */
    function getChildren(){
        return array();
    }
}
