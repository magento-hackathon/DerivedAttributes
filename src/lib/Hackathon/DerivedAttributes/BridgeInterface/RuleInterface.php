<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Attribute;

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
     * Return condition
     *
     * @return RuleConditionInterface
     */
    function getRuleCondition();

    /**
     * Return sorted array of filters
     *
     * @return RuleFilterInterface[]
     */
    function getRuleFilters();

    /**
     * Return rule priority (higher number = more priority)
     *
     * @return int
     */
    function getPriority();
}