<?php
namespace Hackathon\DerivedAttributes\Service\Condition;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;

class AlwaysCondition implements ConditionInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Always';
    const DESCRIPTION = 'Always true.';

    private $data;

    /**
     * @param string $data
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
        return true;
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