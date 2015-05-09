<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class BooleanAttributeCondition implements ConditionInterface
{
    /**
     * @param EntityInterface $product
     * @return boolean
     */
    function match(EntityInterface $product)
    {
        // TODO: Implement match() method.
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