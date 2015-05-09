<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 17:59
 */

namespace Hackathon\DerivedAttributes\ServiceInterface;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;

interface ConditionInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @param EntityInterface $product
     * @return boolean
     */
    function match(EntityInterface $product);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}