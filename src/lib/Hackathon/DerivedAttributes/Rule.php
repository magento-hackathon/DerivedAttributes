<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:08
 */

namespace Hackathon\DerivedAttributes;

use SGH\Comparable\Comparable;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class Rule implements Comparable
{
    /**
     * @var int
     */
    private $priority;
    /**
     * @var bool
     */
    private $active;
    /**
     * @var Attribute
     */
    private $attribute;
    /**
     * @var ConditionInterface
     */
    private $condition;
    /**
     * @var GeneratorInterface
     */
    private $generator;
    /**
     * @var FilterInterface[]
     * @todo add filters
     */
    private $filters = [];

    function __construct(RuleBuilder $builder)
    {
        $this->attribute = $builder->getAttribute();
        $this->condition = $builder->getCondition();
        $this->generator = $builder->getGenerator();
        $this->priority  = $builder->getPriority();
        $this->active    = $builder->isActive();
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return ConditionInterface
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return GeneratorInterface
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    public function compareTo($object)
    {
        return $this->getPriority() - $object->getPriority();
    }

    /**
     * Applies attribute rule to product. Returns true if rule was applicable
     *
     * @param EntityInterface $product
     * @return bool
     */
    public function applyToEntity(EntityInterface $product)
    {
        if ($this->condition->match($product)) {
            $value = $this->generator->generateAttributeValue($product);
            $product->setAttributeValue($this->getAttribute(), $value);
            return true;
        }
        return false;
    }
}