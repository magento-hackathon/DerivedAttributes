<?php
namespace Hackathon\DerivedAttributes\Service\Generator\Condition;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class BooleanAttributeCondition implements ConditionInterface
{
    /**
     * @param EntityInterface $product
     * @param RuleInterface $ruleInstance
     * @return boolean
     */
    function match(EntityInterface $product, RuleInterface $ruleInstance)
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