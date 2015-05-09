<?php
namespace Hackathon\DerivedAttributes\Service\Generator;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class TemplateGenerator implements GeneratorInterface
{
    const __CLASS = __CLASS__;
    /**
     * @param EntityInterface $product
     * @param RuleInterface $ruleEntity
     * @return mixed
     */
    function generateAttributeValue(EntityInterface $product, RuleInterface $ruleEntity)
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