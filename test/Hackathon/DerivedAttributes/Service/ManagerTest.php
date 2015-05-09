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
}