<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;
use Hackathon\DerivedAttributes\RuleSet;

/**
 * Interface RuleLoggerInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface RuleRepositoryInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * Returns rule set with all active rules
     *
     * @return RuleSet
     */
    function findActive();
}