<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

/**
 * Interface RuleLoggerInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface RuleLoggerInterface
{
    const __INTERFACE = __CLASS__;

    function logAppliedRule(RuleInterface $rule, $value);
}