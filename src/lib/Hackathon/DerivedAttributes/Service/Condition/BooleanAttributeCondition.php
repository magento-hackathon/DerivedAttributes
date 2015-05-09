<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class BooleanAttributeCondition implements ConditionInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Boolean Attribute';
    const DESCRIPTION = 'Match if a certain attribute is "1"';

    private $data;

    /**
     * @param string $data
     * @return $this
     */
    public function configure($data)
    {
        $this->data = $data;
        // TODO: Implement configure() method.
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