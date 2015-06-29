<?php
use Hackathon\DerivedAttributes\StoreSet;
use Hackathon\DerivedAttributes\Rule;

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 * @loadFixture products.yaml
 */
class Hackathon_DerivedAttributes_Test_Model_Bridge_RuleRepository extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @dataProvider dataStoreSets
     * @loadExpectation rulesets.yaml
     * @param StoreSet $stores
     */
    public function testFindRuleSetsForStores(StoreSet $stores)
    {
        $ruleRepository = Mage::getModel('derivedattributes/bridge_ruleRepository');
        $actualRuleSets = $ruleRepository->findRuleSetsForStores($stores);
        $expectedRuleSets = $this->expected('stores-%s', join('-', $stores->getStoreCodes()))->getData('rulesets');
        $this->assertEquals(count($expectedRuleSets), count($actualRuleSets), 'Expected number of rule sets');
        $actualRuleSets->rewind();
        while ($actualRuleSets->valid()) {
            $this->assertArrayHasKey((string) $actualRuleSets->key(), $expectedRuleSets, 'Expected store code');
            $expectedRuleIds = $expectedRuleSets[(string) $actualRuleSets->key()];
            $actualRules = $actualRuleSets->current()->getRules();
            $this->assertEquals($expectedRuleIds, array_map(function(Rule $rule) use ($ruleRepository) {
                return $ruleRepository->getRuleId($rule);
            }, $actualRules), 'Expected rules');
            $actualRuleSets->next();
        }

    }
    public static function dataStoreSets()
    {
        $helper = Mage::helper('derivedattributes');
        return array(
            [$helper->createStoreSet(['0'], true)],
            [$helper->createStoreSet(['1'])],
            [$helper->createStoreSet(['2'])]
        );
    }
}