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
     * Return generator
     *
     * @return RuleGeneratorInterface
     */
    function getRuleGenerator();

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