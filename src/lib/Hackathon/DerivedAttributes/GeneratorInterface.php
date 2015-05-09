<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 18:00
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Implementor\EntityInterface;
use Hackathon\DerivedAttributes\Implementor\RuleInterface;

interface GeneratorInterface
{
    const __CLASS = __CLASS__;

    /**
     * @param EntityInterface $product
     * @param RuleInterface $ruleEntity
     * @return mixed
     */
    function generateAttributeValue(EntityInterface $product, RuleInterface $ruleEntity);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}