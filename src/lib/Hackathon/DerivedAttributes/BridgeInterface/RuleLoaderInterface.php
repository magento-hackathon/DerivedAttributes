<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\RuleSet;

interface RuleLoaderInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @return RuleSet
     */
    function getRuleset();
}