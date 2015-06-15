<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

/**
 * Interface RuleLoggerInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface RuleRepositoryInterface
{
    const __INTERFACE = __CLASS__;

    function findActive();
}