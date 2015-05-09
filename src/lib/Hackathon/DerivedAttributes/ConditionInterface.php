<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 17:59
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Implementor\EntityInterface;
use Hackathon\DerivedAttributes\Implementor\RuleInterface;

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