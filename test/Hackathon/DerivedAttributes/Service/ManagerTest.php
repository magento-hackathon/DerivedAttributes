<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    
 * @copyright  Copyright (c) 2015 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleGeneratorInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;
use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAvailableGeneratorTypes()
    {
        $manager = new Manager();
        $actualTypes = $manager->getAvailableGeneratorTypes();
        $this->assertEquals(
            ['template' => ['title' => TemplateGenerator::TITLE, 'description' => TemplateGenerator::DESCRIPTION]],
            $actualTypes, '', 0.0, 10, true);
    }
    /**
     * @test
     */
    public function shouldReturnAvailableConditionTypes()
    {
        $manager = new Manager();
        $actualTypes = $manager->getAvailableConditionTypes();
        $this->assertEquals(
            ['boolean-attribute' => ['title' => BooleanAttributeCondition::TITLE, 'description' => BooleanAttributeCondition::DESCRIPTION]],
            $actualTypes, '', 0.0, 10, true);
    }

    /**
     * @test
     * @dataProvider getConditionData
     */
    public function shouldInstantiateConfiguredCondition($conditionType, $conditionData, $expectedClass)
    {
        $manager = new Manager();
        $conditionStub = $this->getMock(RuleConditionInterface::__INTERFACE, ['getConditionType', 'getConditionData', 'getChildren']);
        $conditionStub->expects($this->any())
            ->method('getConditionType')
            ->will($this->returnValue($conditionType));
        $conditionStub->expects($this->any())
            ->method('getConditionData')
            ->will($this->returnValue($conditionData));
        $condition = $manager->getConditionFromEntity($conditionStub);
        $this->assertInstanceOf($expectedClass, $condition);
        $this->assertEquals($conditionData, $condition->getData());
    }

    /**
     * Data provider
     */
    public static function getConditionData()
    {
        return array(
            [ 'boolean-attribute', 'this-is-an-attribute-code', BooleanAttributeCondition::__CLASS ]
        );
    }

    /**
     * @test
     * @dataProvider getGeneratorData
     */
    public function shouldInstantiateConfiguredGenerator($generatorType, $generatorData, $expectedClass)
    {
        $manager = new Manager();
        $generatorStub = $this->getMock(RuleGeneratorInterface::__INTERFACE, ['getGeneratorType', 'getGeneratorData']);
        $generatorStub->expects($this->any())
            ->method('getGeneratorType')
            ->will($this->returnValue($generatorType));
        $generatorStub->expects($this->any())
            ->method('getGeneratorData')
            ->will($this->returnValue($generatorData));
        $generator = $manager->getGeneratorFromEntity($generatorStub);
        $this->assertInstanceOf($expectedClass, $generator);
        $this->assertEquals($generatorData, $generator->getData());
    }

    /**
     * Data provider
     */
    public static function getGeneratorData()
    {
        return array(
            [ 'template', 'this is a template with #some-attribute#', TemplateGenerator::__CLASS ]
        );
    }
}