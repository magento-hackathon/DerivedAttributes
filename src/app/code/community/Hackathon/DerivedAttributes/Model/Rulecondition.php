<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;

/**
 * Bridge-entity for rule-condition(s).
 */
class Hackathon_DerivedAttributes_Model_Rulecondition
    extends Varien_Object
    implements RuleConditionInterface{

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
