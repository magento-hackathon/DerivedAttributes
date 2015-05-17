<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoggerInterface;
use SGH\Comparable\Comparable;
use SGH\Comparable\ComparatorException;
use SGH\Comparable\SortFunctions;

/**
 * A set of priorized rules
 *
 * @package Hackathon\DerivedAttributes
 */
class RuleSet
{
    const __CLASS = __CLASS__;
    /**
     * @var Rule[]
     */
    private $rules = array();

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return void
     */
    private function sortRules()
    {
        SortFunctions::sort($this->rules);
    }

    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function applyToEntity(EntityInterface $entity, RuleLoggerInterface $logger)
    {
        $affectedAttributes = array();
        $this->sortRules();
        foreach ($this->rules as $rule) {
            $code = $rule->getAttribute()->getAttributeCode();
            if (isset($affectedAttributes[$code])) {
                break;
            }
            if ($rule->applyToEntity($entity)) {
                $logger->logAppliedRule($rule->getRuleEntity(), $entity->getAttributeValue($rule->getAttribute()));
                $affectedAttributes[$code] = true;
            }
        }
    }
}