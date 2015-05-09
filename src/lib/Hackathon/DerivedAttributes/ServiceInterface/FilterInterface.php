<?php
namespace Hackathon\DerivedAttributes\ServiceInterface;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleFilterInterface;

interface FilterInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @param string $data
     * @return $this
     */
    function configure($data);

    /**
     * @param EntityInterface $entity
     * @param mixed $currentValue
     * @return mixed
     */
    function filter(EntityInterface $entity, $currentValue);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}