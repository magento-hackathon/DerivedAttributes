<?php
namespace Hackathon\DerivedAttributes\ServiceInterface;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleFilterInterface;

interface FilterInterface
{
    const __CLASS = __CLASS__;

    /**
     * @param EntityInterface $entity
     * @param RuleFilterInterface $filterEntity
     * @param mixed $currentValue
     * @return mixed
     */
    function filter(EntityInterface $entity, RuleFilterInterface $filterEntity, $currentValue);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}