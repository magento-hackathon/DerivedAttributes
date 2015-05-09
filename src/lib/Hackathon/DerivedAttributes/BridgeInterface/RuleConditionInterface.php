<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

interface RuleConditionInterface
{
    const __INTERFACE = __CLASS__;

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

    /**
     * @return RuleConditionInterface[]
     */
    function getChildren();
}