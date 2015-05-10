<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleFilterInterface;

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Resource_RuleFilter
    extends Mage_Core_Model_Mysql4_Abstract
    implements RuleFilterInterface{
    
	/**
     * @SuppressWarnings(PHPMD)
	 * @see Varien_Object::_construct()
	 */
    protected function _construct(){
        $this->_init("derivedattributes/rule_filter", "rule_filter_id");
    }

    /**
     * Return the Filter type
     *
     * @return string
     */
    function getFilterType(){
        return $this->getData("filter_type");
    }

    /**
     * Return information for instantiating the filter
     *
     * @return string
     */
    function getFilterData(){
        return $this->getData("filter_data");
    }

}
