<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;

/**
 * Event-observer for derived attributes.
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

    }

    /**
     * Returns the Attribute instance
     *
     * @return Attribute
     */
    function getAttribute(){

    }

    /**
     * Return the Generator type
     *
     * @return string
     */
    function getGeneratorType(){

    }

    /**
     * Return information for instantiating the generator
     *
     * @return string
     */
    function getGeneratorData(){

    }

    /**
     * Return condition
     *
     * @return RuleConditionInterface
     */
    function getRuleCondition(){

    }

    /**
     * Return sorted array of filters
     *
     * @return RuleFilterInterface[]
     */
    function getRuleFilters(){

    }

    /**
     * Return rule priority (higher number = more priority)
     *
     * @return int
     */
    function getPriority(){

    }

}
