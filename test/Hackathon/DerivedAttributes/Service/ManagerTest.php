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
use Hackathon\DerivedAttributes\Service\Condition\AlwaysCondition;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;
use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

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
            [
                'boolean-attribute' => ['title' => BooleanAttributeCondition::TITLE, 'description' => BooleanAttributeCondition::DESCRIPTION],
                'always' => ['title' => AlwaysCondition::TITLE, 'description' => AlwaysCondition::DESCRIPTION],
            ],
            $actualTypes, '', 0.0, 10);
    }

    /**
     * @test
     * @dataProvider getConditionData
     */
    public function shouldInstantiateConfiguredCondition($conditionType, $conditionData, $expectedClass)
    {
        $manager = new Manager();
        $condition = $manager->getCondition($conditionType, $conditionData);
        $this->assertInstanceOf($expectedClass, $condition);
        $this->assertEquals($conditionData, $condition->getData());
    }

    /**
     * @param $conditionType
     * @param $conditionData
     * @test
     * @dataProvider getInvalidConditionData
     * @expectedException \InvalidArgumentException
     */
    public function shouldFailConditionInstantiation($conditionType, $conditionData)
    {
        $manager = new Manager();
        $manager->getCondition($conditionType, $conditionData);
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
     * Data provider
     */
    public static function getInvalidConditionData()
    {
        return array(
            [ 'non-existent-id', 'arbitrary data' ]
        );
    }

    /**
     * @test
     * @dataProvider getGeneratorData
     * @param $generatorType
     * @param $generatorData
     * @param $expectedClass
     */
    public function shouldInstantiateConfiguredGenerator($generatorType, $generatorData, $expectedClass)
    {
        $manager = new Manager();
        $generator = $manager->getGenerator($generatorType, $generatorData);
        $this->assertInstanceOf($expectedClass, $generator);
        $this->assertEquals($generatorData, $generator->getData());
    }

    /**
     * @param $generatorType
     * @param $generatorData
     * @test
     * @dataProvider getInvalidGeneratorData
     * @expectedException \InvalidArgumentException
     */
    public function shouldFailGeneratorInstantiation($generatorType, $generatorData)
    {
        $manager = new Manager();
        $manager->getGenerator($generatorType, $generatorData);
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

    /**
     * Data provider
     */
    public static function getInvalidGeneratorData()
    {
        return array(
            [ 'non-existent-id', 'arbitrary data' ]
        );
    }

    /**
     * @test
     */
    public function shouldDetermineConditionType()
    {
        $manager = new Manager();
        $this->assertEquals('always', $manager->getConditionType(new AlwaysCondition()));
    }

    /**
     * @test
     */
    public function shouldDetermineGeneratorType()
    {
        $manager = new Manager();
        $this->assertEquals('template', $manager->getGeneratorType(new TemplateGenerator()));
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldFailWithInvalidConditionType()
    {
        $manager = new Manager();
        $manager->getConditionType($this->getMockForAbstractClass(ConditionInterface::__INTERFACE));
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldFailWithInvalidGeneratorType()
    {
        $manager = new Manager();
        $manager->getGeneratorType($this->getMockForAbstractClass(GeneratorInterface::__INTERFACE));
    }
}