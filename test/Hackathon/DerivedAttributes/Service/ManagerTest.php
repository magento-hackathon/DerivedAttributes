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

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAvailableGeneratorTypes()
    {
        $manager = new Manager();
        $this->assertEquals(['template'], $manager->getAvailableGeneratorTypes(), '', 0.0, 10, true);
    }
    /**
     * @test
     */
    public function shouldReturnAvailableConditionTypes()
    {
        $manager = new Manager();
        $this->assertEquals(['boolean-attribute'], $manager->getAvailableConditionTypes(), '', 0.0, 10, true);
    }
}