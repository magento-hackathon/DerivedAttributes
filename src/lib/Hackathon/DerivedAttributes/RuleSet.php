<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use SGH\Comparable\SortFunctions;

class RuleSet
{
    /**
     * @var Rule[]
     */
    private $rules;
    /**
     * @var Attribute
     */
    private $attribute;

    function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
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
    public function applyToEntity(EntityInterface $entity)
    {
        $this->sortRules();
        foreach ($this->rules as $rule) {
            if ($rule->applyToEntity($entity)) {
                break;
            }
        }
    }
} 