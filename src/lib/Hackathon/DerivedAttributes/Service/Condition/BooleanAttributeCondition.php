<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class BooleanAttributeCondition implements ConditionInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Boolean Attribute';
    const DESCRIPTION = 'Match attribute with given attribute code is "1".';

    private $data;

    /**
     * @param string $data Attribute Code
     * @return $this
     */
    public function configure($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @internal used to test instantiation
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @param EntityInterface $entity
     * @return boolean
     */
    public function match(EntityInterface $entity)
    {
        return (bool) $entity->getAttributeValue(new Attribute($this->data));
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