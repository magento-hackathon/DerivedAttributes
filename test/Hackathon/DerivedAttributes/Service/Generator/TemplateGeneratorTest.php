<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;

class TemplateGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $value
     * @test
     * @dataProvider getAttributeData
     */
    public function shouldMatchIfAttributeTrue($data, $value, $value2, $expected_value)
    {
        $attribute = new Attribute('some-attribute-code');
        $attribute2 = new Attribute('some-attribute-code2');

        $entityStub = $this->getMock(EntityInterface::__INTERFACE);

        $entityStub->expects($this->any())
            ->method('getAttributeValue')
            ->willReturnCallback(
                function ($attributeCode) use ($value, $value2) {
                    switch ($attributeCode->getAttributeCode()) {
                        case 'some-attribute-code':
                            return $value;
                        case 'some-attribute-code2':
                            return $value2;
                        default:
                            return 'default attribute value';
                    }
                }
            );

        $generator = new TemplateGenerator();
        $generator->configure($data);

        $this->assertEquals($expected_value, $generator->generateAttributeValue($entityStub));
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function getAttributeData()
    {
        return array(
            [ 'Buy #some-attribute-code# products in #some-attribute-code2#.', 'homemade $%$&%$%&-äöé foo </br> bar', '38', 'Buy homemade $%$&%$%&-äöé foo </br> bar products in 38.' ],

        );
    }
}