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

}
