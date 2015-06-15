<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\RuleSet;

/**
 * Interface RuleLoaderInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 * @deprecated in favor of RuleRepositoryInterface
 */
interface RuleLoaderInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @return RuleSet
     */
    function getRuleset();
}