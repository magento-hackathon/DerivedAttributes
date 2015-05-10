<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleFilterInterface;

/**
 * Bridge-entity for rule-filter(s).
 */
class Hackathon_DerivedAttributes_Model_Rulefilter
    extends Mage_Core_Model_Abstract
    implements RuleFilterInterface{
    
	/**
     * @SuppressWarnings(PHPMD)
	 * @see Varien_Object::_construct()
	 */
    protected function _construct(){
        $this->_init("derivedattributes/rulefilter");
    }

}
