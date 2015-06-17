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
        $enityTypeCode = 'some-entity-type-code';
        $attributeCode = 'some-attribute-code';
        $attribute = new Attribute($enityTypeCode, $attributeCode);
        $entityStub = $this->getMock(EntityInterface::__INTERFACE);
        $entityStub->expects($this->any())
            ->method('getAttributeValue')
            ->with($attribute)
            ->willReturn($value);
        $entityStub->expects($this->any())
            ->method('getEntityTypeCode')
            ->willReturn($enityTypeCode);
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