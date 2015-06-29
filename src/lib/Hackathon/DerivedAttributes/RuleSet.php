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

    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function applyToEntity(EntityInterface $entity, RuleLoggerInterface $logger)
    {
        $affectedAttributes = array();
        foreach ($this->rules as $rule) {
            $code = $rule->getAttribute()->getAttributeCode();
            if (isset($affectedAttributes[$code])) {
                break;
            }
            if ($rule->applyToEntity($entity)) {
                $logger->logAppliedRule($rule, $entity->getAttributeValue($rule->getAttribute()));
                $affectedAttributes[$code] = true;
            }
        }
    }
}