<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;
use Hackathon\DerivedAttributes\Rule;
use Hackathon\DerivedAttributes\RuleSetsByStore;
use Hackathon\DerivedAttributes\StoreSet;

/**
 * Interface RuleLoggerInterface
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface RuleRepositoryInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * Returns rule sets with all active rules, grouped by store, ordered by priority
     *
     * @param StoreSet $stores
     * @return RuleSetsByStore
     */
    function findRuleSetsForStores(StoreSet $stores);

    /**
     * @param Rule $newRule
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