<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;
use Hackathon\DerivedAttributes\Rule;

/**
 * Interface RuleLoggerInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface RuleLoggerInterface
{
    const __INTERFACE = __CLASS__;

    function logAppliedRule(Rule $rule, $value);
}