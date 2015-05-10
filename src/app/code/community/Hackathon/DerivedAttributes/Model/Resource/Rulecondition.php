<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Resource_Rulecondition
    extends Mage_Core_Model_Mysql4_Abstract{
    
	/**
     * @SuppressWarnings(PHPMD)
	 * @see Varien_Object::_construct()
	 */
    protected function _construct(){
        $this->_init("derivedattributes/rulecondition", "rule_condition_id");
    }

}
