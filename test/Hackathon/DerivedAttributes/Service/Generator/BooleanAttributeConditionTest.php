<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;

class BooleanAttributeConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $value
     * @test
     * @dataProvider getAttributeData
     */
    public function shouldMatchIfAttributeTrue($value)
    {
        $attributeCode = 'some-attribute-code';
        $attribute = new Attribute($attributeCode);
        $entityStub = $this->getMock(EntityInterface::__INTERFACE);
        $entityStub->expects($this->any())
            ->method('getAttributeValue')
            ->with($attribute)
            ->willReturn($value);
        $condition = new BooleanAttributeCondition();
        $condition->configure($attributeCode);
        $this->assertEquals((bool) $value, $condition->match($entityStub));
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function getAttributeData()
    {
        return array(
            [ 0 ],
            [ 1 ]
        );
    }
}