<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class BooleanAttributeCondition implements ConditionInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Boolean Attribute';
    const DESCRIPTION = 'Match if a certain attribute is "1"';

    /**
     * @param EntityInterface $product
     * @return boolean
     */
    public function match(EntityInterface $product)
    {
        // TODO: Implement match() method.
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return self::TITLE;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return self::DESCRIPTION;
    }

}