<?php
namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class RuleBuilderTest extends \PHPUnit_Framework_TestCase
{
    const DEFAULT_PRIORITY       = 0;
    const DEFAULT_ACTIVE         = true;
    const DEFAULT_NAME           = 'New Rule';
    const DEFAULT_DESCRIPTION    = '';
    const DEFAULT_CONDITION_TYPE = 'always';
    const DEFAULT_CONDITION_DATA = '';
    const DEFAULT_GENERATOR_TYPE = 'template';
    const DEFAULT_GENERATOR_DATA = '';
    /**
     * @test
     * @dataProvider dataDefaultAttributes
     */
    public function ruleShouldBeBuiltWithDefaultAttributes($ruleData)
    {
        $conditionStub = $this->getMockForAbstractClass(ConditionInterface::__INTERFACE);
        $generatorStub = $this->getMockForAbstractClass(GeneratorInterface::__INTERFACE);
        $managerMock = $this->getManagerMock($ruleData, $conditionStub, $generatorStub);

        $attribute = new Attribute($ruleData['attribute_code']);
        $stores = StoreSet::all();

        $builder = new RuleBuilder($managerMock, $attribute);

        $actualRule = $builder->build();
        $this->assertRuleData($ruleData, $attribute, $conditionStub, $generatorStub, $stores, $actualRule);
    }
    public static function dataDefaultAttributes()
    {
        return [[
            'ruleData' => [
                'attribute_code' => 'dummy-1',
                'name' => self::DEFAULT_NAME, 'description' => self::DEFAULT_DESCRIPTION,
                'active' => self::DEFAULT_ACTIVE, 'priority' => self::DEFAULT_PRIORITY,
                'condition_type' => self::DEFAULT_CONDITION_TYPE, 'condition_data' => self::DEFAULT_CONDITION_DATA,
                'generator_type' => self::DEFAULT_GENERATOR_TYPE, 'generator_data' => self::DEFAULT_GENERATOR_DATA
            ]
        ]];
    }
    /**
     * @test
     * @dataProvider dataOptionalAttributes
     */
    public function ruleShouldBeBuiltWithOptionalAttributes($ruleData)
    {
        $conditionStub = $this->getMockForAbstractClass(ConditionInterface::__INTERFACE);
        $generatorStub = $this->getMockForAbstractClass(GeneratorInterface::__INTERFACE);
        $managerMock = $this->getManagerMock($ruleData, $conditionStub, $generatorStub);

        $attribute = new Attribute($ruleData['attribute_code']);
        $stores = new StoreSet($ruleData['store_codes']);

        $builder = new RuleBuilder($managerMock, $attribute);
        $builder
            ->setPriority($ruleData['priority'])
            ->setActive($ruleData['active'])
            ->setConditionType($ruleData['condition_type'])
            ->setConditionData($ruleData['condition_data'])
            ->setGeneratorType($ruleData['generator_type'])
            ->setGeneratorData($ruleData['generator_data'])
            ->setName($ruleData['name'])
            ->setDescription($ruleData['description'])
            ->setStores($stores);

        $actualRule = $builder->build();
        $this->assertRuleData($ruleData, $attribute, $conditionStub, $generatorStub, $stores, $actualRule);
    }
    public static function dataOptionalAttributes()
    {
        return [[
            'ruleData' => [
                'attribute_code' => 'dummy-1', 'store_codes' => ['store-1', 'store-2'],
                'name' => 'Rule 1', 'description' => 'First Rule',
                'active' => true, 'priority' => 1,
                'condition_type' => 'boolean_attribute', 'condition_data' => 'dummy-attribute',
                'generator_type' => 'template', 'generator_data' => 'dummy-template'
            ]
        ], [
            'ruleData' => [
                'attribute_code' => 'dummy-2', 'store_codes' => ['store-1', 'store-2'],
                'name' => 'Rule 2', 'description' => 'Second Rule',
                'active' => false, 'priority' => 2,
                'condition_type' => 'dummy_type', 'condition_data' => 'dummy-data',
                'generator_type' => 'dummy_type', 'generator_data' => 'dummy-data'
            ]
        ]];
    }

    /**
     * @param $withRuleData
     * @param $returnConditionStub
     * @param $returnGeneratorStub
     * @return \PHPUnit_Framework_MockObject_MockObject|Manager
     */
    private function getManagerMock($withRuleData, $returnConditionStub, $returnGeneratorStub)
    {
        $managerMock = $this->getMock(Manager::__CLASS, ['getCondition', 'getGenerator']);
        $managerMock->expects($this->any())
            ->method('getCondition')
            ->with($withRuleData['condition_type'], $withRuleData['condition_data'])
            ->will($this->returnValue($returnConditionStub));
        $managerMock->expects($this->any())
            ->method('getGenerator')
            ->with($withRuleData['generator_type'], $withRuleData['generator_data'])
            ->will($this->returnValue($returnGeneratorStub));
        return $managerMock;
    }

    /**
     * @param $expectedRuleData
     * @param $expectedAttribute
     * @param $expectedCondition
     * @param $expectedGenerator
     * @param Rule $actualRule
     */
    private function assertRuleData($expectedRuleData, $expectedAttribute, $expectedCondition, $expectedGenerator, $expectedStores, $actualRule)
    {
        $this->assertSame($expectedAttribute, $actualRule->getAttribute());
        $this->assertSame($expectedStores, $actualRule->getStores());
        $this->assertSame($expectedCondition, $actualRule->getCondition());
        $this->assertSame($expectedGenerator, $actualRule->getGenerator());
        $this->assertEquals($expectedRuleData['priority'], $actualRule->getPriority());
        $this->assertEquals($expectedRuleData['active'], $actualRule->isActive());
        $this->assertEquals($expectedRuleData['name'], $actualRule->getName());
        $this->assertEquals($expectedRuleData['description'], $actualRule->getDescription());
    }
}
