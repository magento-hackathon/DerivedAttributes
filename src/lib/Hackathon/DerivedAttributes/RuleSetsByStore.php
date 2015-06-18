<?php

namespace Hackathon\DerivedAttributes;
use Iterator;

/**
 * A set of priorized rules
 *
 * @package Hackathon\DerivedAttributes
 */
class RuleSetsByStore implements Iterator
{
    private $ruleSets = array();
    private $stores = array();

    /**
     * @param RuleSet $ruleSet
     * @param string $storeCode
     * @return void
     */
    public function addRuleSet(RuleSet $ruleSet, $storeCode)
    {
        $this->ruleSets[(string) $storeCode] = $ruleSet;
        $this->stores[(string) $storeCode] = $storeCode; //TODO expect store as parameter
    }

    /**
     * @param string $storeCode
     * @return RuleSet
     */
    public function getRuleSet($storeCode)
    {
        if (! isset($this->ruleSets[(string) $storeCode])) { //TODO expect Store as parameter
            throw new \OutOfBoundsException("No rule set found for store {$storeCode}");
        }
        return $this->ruleSets[(string) $storeCode];
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


}