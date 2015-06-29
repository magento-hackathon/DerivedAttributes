<?php

namespace Hackathon\DerivedAttributes;
use Iterator;
use Countable;

/**
 * A set of priorized rules
 *
 * @package Hackathon\DerivedAttributes
 */
class RuleSetsByStore implements Iterator, Countable
{
    private $ruleSets = array();
    private $stores = array();

    /**
     * @param RuleSet $ruleSet
     * @param Store $store
     * @return void
     */
    public function addRuleSet(RuleSet $ruleSet, Store $store)
    {
        $this->ruleSets[(string) $store] = $ruleSet;
        $this->stores[(string) $store] = $store;
    }

    /**
     * @param Store $store
     * @return RuleSet
     */
    public function getRuleSet(Store $store)
    {
        if (! isset($this->ruleSets[(string) $store])) {
            throw new \OutOfBoundsException("No rule set found for store {$store}");
        }
        return $this->ruleSets[(string) $store];
    }

    public function current()
    {
        return current($this->ruleSets);
    }

    public function next()
    {
        next($this->ruleSets);
        next($this->stores);
    }

    public function key()
    {
        return current($this->stores);
    }

    public function valid()
    {
        return current($this->ruleSets) !== false;
    }

    public function rewind()
    {
        reset($this->ruleSets);
        reset($this->stores);
    }

    public function count()
    {
        return count($this->ruleSets);
    }

}