<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 21:46
 */

namespace IntegerNet\AttributeRule;


use IntegerNet\AttributeRule\Implementor\ProductInterface;

class RuleSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Attribute
     */
    private $mockAttribute;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ProductInterface
     */
    private $mockProduct;

    protected function setUp()
    {
        parent::setUp();
        $this->mockProduct   = $this->getMockForAbstractClass(ProductInterface::__CLASS,
            [], '', true, true, true, [ 'setAttributeValue' ]);
        $this->mockAttribute = $this->getMock(Attribute::__CLASS);
    }

    /**
     * @test
     * @dataProvider getRulesData
     * @param $rulesData
     * @param $expectedAttributeValue
     */
    public function rulesShouldBeAppliedAccordingToConditionsAndPriority($rulesData, $expectedAttributeValue)
    {
        $this->mockProduct->expects($this->atLeastOnce())
            ->method('setAttributeValue')
            ->with($this->mockAttribute, $expectedAttributeValue);
        $ruleSet = new RuleSet($this->mockAttribute);
        $rules = $this->createRulesFromRulesData($rulesData);
        foreach ($rules as $rule)
        {
            $ruleSet->addRule($rule);
        }
        $ruleSet->applyToProduct($this->mockProduct);
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
                ['matches' => true, 'value' => 'foo', 'priority' => 1, 'stop' => false],
            ],
            'expected_attribute_value' => 'foo'
        ];
        $testCases['second_rule_matches'] = [
            'rules_data' => [
                [ 'matches' => false, 'value' => 'foo', 'priority' => 1 ],
                [ 'matches' => true,  'value' => 'bar', 'priority' => 2 ],
            ],
            'expected_attribute_value' => 'bar'
        ];
        $testCases['second_priorized_rule_matches'] = [
            'rules_data' => [
                [ 'matches' => true,  'value' => 'bar', 'priority' => 2 ],
                [ 'matches' => false, 'value' => 'foo', 'priority' => 1 ],
            ],
            'expected_attribute_value' => 'bar'
        ];
        $testCases['multiple_rules_match'] = [
            'rules_data' => [
                [ 'matches' => true, 'value' => 'foo', 'priority' => 1 ],
                [ 'matches' => true, 'value' => 'bar', 'priority' => 2 ]
            ],
            'expected_attribute_value' => 'foo'
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
            $mockCondition = $this->getMock(Condition::__CLASS, [ 'match' ]);
            $mockCondition->expects($this->any())
                ->method('match')
                ->with($this->mockProduct)
                ->willReturn($ruleData['matches']);
            $mockGenerator = $this->getMock(Generator::__CLASS, [ 'generateAttributeValue' ]);
            $mockGenerator->expects($this->any())
                ->method('generateAttributeValue')
                ->with($this->mockProduct, $this->mockAttribute)
                ->willReturn($ruleData['value']);
            $rules[] = new Rule(
                $this->mockAttribute, $mockCondition, $mockGenerator, $ruleData['priority']);
        }
        return $rules;
    }
}
 