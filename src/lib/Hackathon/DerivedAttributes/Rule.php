<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:08
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Implementor\ProductInterface;
use \Comparable;

class Rule implements \SGH\Comparable\Comparable
{
    /**
     * @var int
     */
    private $priority;
    /**
     * @var Attribute
     */
    private $attribute;
    /**
     * @var Condition
     */
    private $condition;
    /**
     * @var Generator
     */
    private $generator;

    function __construct(Attribute $attribute, Condition $condition, Generator $generator, $priority = 0)
    {
        $this->attribute = $attribute;
        $this->condition = $condition;
        $this->generator = $generator;
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return void
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    public function compareTo($object)
    {
        //TODO TypeSafeComparator that only takes objects of certain class
        assert($object instanceof self);
        return $this->getPriority() - $object->getPriority();
    }

    /**
     * Applies attribute rule to product. Returns true if rule was applicable
     *
     * @param ProductInterface $product
     * @return bool
     */
    public function applyToProduct(ProductInterface $product)
    {
        if ($this->condition->match($product)) {
            $value = $this->generator->generateAttributeValue($product, $this->getAttribute());
            $product->setAttributeValue($this->getAttribute(), $value);
            return true;
        }
        return false;
    }
}