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
    const __CLASS = __CLASS__;

    /**
     * @param EntityInterface $product
     * @param RuleInterface $ruleInstance
     * @return boolean
     */
    function match(EntityInterface $product, RuleInterface $ruleInstance);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}