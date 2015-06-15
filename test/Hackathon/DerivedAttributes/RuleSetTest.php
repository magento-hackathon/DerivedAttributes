<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 21:46
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleGeneratorInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoggerInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class RuleSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Attribute[]
     */
    private $attributeStubs;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EntityInterface
     */
    private $productMock;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RuleLoggerInterface
     */
    private $ruleLoggerMock;

    protected function setUp()
    {
        parent::setUp();
        $this->productMock   = $this->getMockForAbstractClass(EntityInterface::__INTERFACE,
            [], '', true, true, true, [ 'setAttributeValue' ]);
        $this->attributeStubs['dummy-1'] = $this->getMock(Attribute::__CLASS, null, ['dummy-1']);
        $this->attributeStubs['dummy-2'] = $this->getMock(Attribute::__CLASS, null, ['dummy-2']);
        $this->ruleLoggerMock = $this->getMockForAbstractClass(RuleLoggerInterface::__INTERFACE);
    }

    /**
     * @test
     * @dataProvider getRulesData
     * @param $rulesData
     * @param $expectedAttributeValue
     */
    public function rulesShouldBeAppliedAccordingToConditionsAndPriority($rulesData, $expectedAttributeValue)
    {
        $this->productMock->expects($this->atLeastOnce())
            ->method('setAttributeValue')
            ->with($this->attributeStubs['dummy-1'], $expectedAttributeValue);
        $ruleSet = new RuleSet();
        $rules = $this->createRulesFromRulesData($rulesData);
        foreach ($rules as $rule)
        {
            $ruleSet->addRule($rule);
        }
        $ruleSet->applyToEntity($this->productMock, $this->ruleLoggerMock);
    }

    /**
     * @test
     * @dataProvider getRulesForMultipleAttributesData
     * @param $rulesData
     * @param $expectedAttributeValues
     */
    public function ruleSetShouldBeAttributeIndependentAndLogged($rulesData, $expectedAttributeValues)
    {
        $actualAttributeValues = array();
        $actualLoggedRules = array();
        $this->productMock->expects($this->any())
            ->method('setAttributeValue')
            ->willReturnCallback(function(Attribute $attribute, $value) use (&$actualAttributeValues) {
                $actualAttributeValues[$attribute->getAttributeCode()] = $value;
            });
        $this->productMock->expects($this->any())
            ->method('getAttributeValue')
            ->willReturnCallback(function(Attribute $attribute) use (&$actualAttributeValues) {
                if (isset($actualAttributeValues[$attribute->getAttributeCode()])) {
                    return $actualAttributeValues[$attribute->getAttributeCode()];
                }
            });
        $this->ruleLoggerMock->expects($this->any())
            ->method('logAppliedRule')
            ->willReturnCallback(function(RuleInterface $rule, $value) use (&$actualLoggedRules) {
                $actualLoggedRules[$rule->getAttribute()->getAttributeCode()] = $value;
            });
        $ruleSet = new RuleSet();
        $rules = $this->createRulesFromRulesData($rulesData);
        foreach ($rules as $rule)
        {
            $ruleSet->addRule($rule);
        }
        $ruleSet->applyToEntity($this->productMock, $this->ruleLoggerMock);
        $this->assertEquals($expectedAttributeValues, $actualAttributeValues);
        $this->assertEquals($expectedAttributeValues, $actualLoggedRules);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function getRulesData()
    {
        $testCases = array();
        $testCases['single_rule'] = [
            'rules_data' => [
                ['matches' => true, 'value' => 'foo', 'priority' => 1, 'stop' => false, 'attribute_index' => 'dummy-1'],
            ],
            'expected_attribute_value' => 'foo'
        ];
        $testCases['second_rule_matches'] = [
            'rules_data' => [
                [ 'matches' => false, 'value' => 'foo', 'priority' => 1, 'attribute_index' => 'dummy-1' ],
                [ 'matches' => true,  'value' => 'bar', 'priority' => 2, 'attribute_index' => 'dummy-1' ],
            ],
            'expected_attribute_value' => 'bar'
        ];
        $testCases['second_priorized_rule_matches'] = [
            'rules_data' => [
                [ 'matches' => true,  'value' => 'bar', 'priority' => 2, 'attribute_index' => 'dummy-1' ],
                [ 'matches' => false, 'value' => 'foo', 'priority' => 1, 'attribute_index' => 'dummy-1' ],
            ],
            'expected_attribute_value' => 'bar'
        ];
        $testCases['multiple_rules_match'] = [
            'rules_data' => [
                [ 'matches' => true, 'value' => 'foo', 'priority' => 1, 'attribute_index' => 'dummy-1' ],
                [ 'matches' => true, 'value' => 'bar', 'priority' => 2, 'attribute_index' => 'dummy-1' ]
            ],
            'expected_attribute_value' => 'foo'
        ];
        return $testCases;
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public static function getRulesForMultipleAttributesData()
    {
        $testCases = array();
        $testCases[] = [
            'rules_data' => [
                'rule-1' => [ 'matches' => true,  'value' => 'narf', 'priority' => 3, 'attribute_index' => 'dummy-2' ],
                'rule-2' => [ 'matches' => false, 'value' => 'foo', 'priority' => 1, 'attribute_index' => 'dummy-1' ],
                'rule-3' => [ 'matches' => true,  'value' => 'bar', 'priority' => 4, 'attribute_index' => 'dummy-1' ],
                'rule-4' => [ 'matches' => true,  'value' => 'baz', 'priority' => 2, 'attribute_index' => 'dummy-1' ],
            ],
            'expected_attribute_values' => [ 'dummy-1' => 'baz', 'dummy-2' => 'narf'],
        ];
        return $testCases;
    }

    /**
     * Convert input from data provider into array of Rule objects
     *
     * @param array $rulesData
     * @return Rule[]
     */
    private function createRulesFromRulesData(array $rulesData)
    {
        $rules = array();
        foreach ($rulesData as $ruleData) {
            $ruleEntityStub = $this->getMock(RuleInterface::__INTERFACE);
            $ruleConditionStub = $this->getMock(RuleConditionInterface::__INTERFACE);
            $ruleGeneratorStub = $this->getMock(RuleGeneratorInterface::__INTERFACE);
            $ruleEntityStub->expects($this->any())
                ->method('getPriority')
                ->will($this->returnValue($ruleData['priority']));
            $ruleEntityStub->expects($this->any())
                ->method('getAttribute')
                ->will($this->returnValue($this->attributeStubs[$ruleData['attribute_index']]));
            $ruleEntityStub->expects($this->any())
                ->method('getRuleCondition')
                ->will($this->returnValue($ruleConditionStub));
            $ruleEntityStub->expects($this->any())
                ->method('getRuleGenerator')
                ->will($this->returnValue($ruleGeneratorStub));

            $conditionStub = $this->getMock(ConditionInterface::__INTERFACE, [ 'match', 'configure', 'getData', 'getTitle', 'getDescription' ]);
            $conditionStub->expects($this->any())
                ->method('match')
                ->with($this->productMock, $ruleEntityStub)
                ->willReturn($ruleData['matches']);

            $generatorStub = $this->getMock(GeneratorInterface::__INTERFACE, [ 'generateAttributeValue', 'configure', 'getData', 'getTitle', 'getDescription' ]);
            $generatorStub->expects($this->any())
                ->method('generateAttributeValue')
                ->with($this->productMock, $ruleEntityStub)
                ->willReturn($ruleData['value']);

            $managerStub = $this->getMock(Manager::__CLASS, [ 'getConditionFromEntity', 'getGeneratorFromEntity']);
            $managerStub->expects($this->any())
                ->method('getConditionFromEntity')
                ->with($ruleConditionStub)
                ->will($this->returnValue($conditionStub));
            $managerStub->expects($this->any())
                ->method('getGeneratorFromEntity')
                ->with($ruleGeneratorStub)
                ->will($this->returnValue($generatorStub));
            $builder = new RuleBuilder($ruleEntityStub, $managerStub);
            $rules[] = $builder->build(
                $ruleEntityStub, $managerStub);
        }
        return $rules;
    }
}