<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Attribute;

//TODO eliminate RuleInterface, RuleFilterInterface, RuleConditionInterface
//     and their implementations
//     use RuleLoaderInterface to construct real objects directly from Magento resource model
interface RuleInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * Returns the Attribute instance
     *
     * @return Attribute
     */
    function getAttribute();

    /**
     * Return rule priority (higher number = more priority)
     *
     * @return int
     */
    function getPriority();
    /**
     * Return the Generator type
     *
     * @return string
     */
    function getGeneratorType();

    /**
     * Return information for instantiating the generator
     *
     * @return string
     */
    function getGeneratorData();
    /**
     * Return the Condition type
     *
     * @return string
     */
    function getConditionType();

    /**
     * Return information for instantiating the condition
     *
     * @return string
     */
    function getConditionData();

}