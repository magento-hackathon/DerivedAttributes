<?php
namespace Hackathon\DerivedAttributes\Service\Generator;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class TemplateGenerator implements GeneratorInterface
{
    const __CLASS = __CLASS__;
    /**
     * @param EntityInterface $product
     * @return mixed
     */
    function generateAttributeValue(EntityInterface $product)
    {
        // TODO: Implement generateAttributeValue() method.
    }

    /**
     * @return string
     */
    function getTitle()
    {
        // TODO: Implement getTitle() method.
    }

    /**
     * @return string
     */
    function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

}