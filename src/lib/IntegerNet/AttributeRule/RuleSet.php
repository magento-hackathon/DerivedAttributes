<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:09
 */

namespace IntegerNet\AttributeRule;


use IntegerNet\AttributeRule\Implementor\ProductInterface;
use \ObjectSorter;

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
        //TODO polish and integrate comparator-tools
        $sorter = new ObjectSorter();
        $sorter->sort($this->rules);
    }

    /**
     * @param ProductInterface $product
     * @internal param Attribute $attribute
     * @return void
     */
    public function applyToProduct(ProductInterface $product)
    {
        $this->sortRules();
        foreach ($this->rules as $rule) {
            if ($rule->applyToProduct($product)) {
                break;
            }
        }
    }
} 