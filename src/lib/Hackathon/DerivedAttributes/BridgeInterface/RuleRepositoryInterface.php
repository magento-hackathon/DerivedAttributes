<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;
use Hackathon\DerivedAttributes\Rule;
use Hackathon\DerivedAttributes\RuleSet;
use Hackathon\DerivedAttributes\StoreSet;

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
    function findRuleSetsForStores(StoreSet $stores);

    /**
     * @param Rule $rule
     * @return void
     */
    function createRule(Rule $newRule);

    /**
     * @param Rule $oldRule
     * @param Rule $newRule
     * @return void
     */
    function replaceRule(Rule $oldRule, Rule $newRule);

    /**
     * @param Rule $ruleToBeDeleted
     * @return void
     */
    function deleteRule(Rule $ruleToBeDeleted);
}