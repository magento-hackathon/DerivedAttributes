<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
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
    /**
     * @var Rule[]
     */
    private $rules = array();
    /**
     * @var Attribute
     * @deprecated
     */
    private $attribute;

    function __construct(Attribute $attribute = null)
    {
        $this->attribute = $attribute;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return Attribute
     * @deprecated
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
        $affectedAttributes = array();
        $this->sortRules();
        foreach ($this->rules as $rule) {
            $code = $rule->getAttribute()->getAttributeCode();
            if (isset($affectedAttributes[$code])) {
                break;
            }
            if ($rule->applyToEntity($entity)) {
                $affectedAttributes[$code] = true;
            }
        }
    }
}