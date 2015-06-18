<?php

namespace Hackathon\DerivedAttributes;

class RuleSetsByStoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldIterateOverRuleSetsByStoreCode()
    {
        $ruleSets = new \SplObjectStorage();
        $ruleSets->attach(new RuleSet(), new Store('1'));
        $ruleSets->attach(new RuleSet(), new Store('2'));

        $ruleSetsByStore = new RuleSetsByStore();
        foreach ($ruleSets as $ruleSet) {
            $ruleSetsByStore->addRuleSet($ruleSet, $ruleSets->getInfo());
        }

        $ruleSets->rewind();
        foreach ($ruleSetsByStore as $actualRuleSet) {
            $actualStore = $ruleSetsByStore->key(); // PHP 5.4 compatible
            $expectedStore = $ruleSets->getInfo();
            $expectedRuleSet = $ruleSets->current();
            $this->assertSame($expectedStore, $actualStore);
            $this->assertSame($expectedRuleSet, $actualRuleSet);
            $ruleSets->next();
        }
        $this->assertFalse($ruleSets->valid(), 'Iterator should yield all rule sets.');
    }

    public function shouldReturnRuleSetByStoreWithCode()
    {
        $ruleSets = array(
            '1' => new RuleSet(),
            '2' => new RuleSet()
        );
        $ruleSetsByStore = new RuleSetsByStore();
        foreach ($ruleSets as $storeCode => $ruleSet) {
            $ruleSetsByStore->addRuleSet($ruleSet, $storeCode);
        }

        $this->assertSame($ruleSet['1'], $ruleSetsByStore->getRuleSet(new Store('1')));
        $this->assertSame($ruleSet['2'], $ruleSetsByStore->getRuleSet(new Store('2')));
    }
}