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
     * @var StoreSet
     */
    private $stores;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
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
        $this->attribute   = $builder->getAttribute();
        $this->condition   = $builder->getCondition();
        $this->generator   = $builder->getGenerator();
        $this->priority    = $builder->getPriority();
        $this->active      = $builder->isActive();
        $this->name        = $builder->getName();
        $this->description = $builder->getDescription();
        $this->stores      = $builder->getStores();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return StoreSet
     */
    public function getStores()
    {
        return $this->stores;
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
     * @param EntityInterface $entity
     * @return bool
     */
    public function applyToEntity(EntityInterface $entity)
    {
        if ($entity->hasAttribute($this->attribute) && $this->condition->match($entity)) {
            $value = $this->generator->generateAttributeValue($entity);
            $entity->setAttributeValue($this->getAttribute(), $value);
            return true;
        }
        return false;
    }
}