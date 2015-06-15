<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 16:08
 */

namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

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
     * @var ConditionInterface
     */
    private $condition;
    /**
     * @var GeneratorInterface
     */
    private $generator;
    /**
     * @var RuleInterface
     */
    private $ruleEntity;
    /**
     * @var FilterInterface[]
     */
    private $filters;

    function __construct($priority, Attribute $attribute, ConditionInterface $condition, GeneratorInterface $generator)
    {
        $this->priority = $priority;
        $this->attribute = $attribute;
        $this->condition = $condition;
        $this->generator = $generator;
        //TODO add filters
    }

    /**
     * @return RuleInterface
     */
    public function getRuleEntity()
    {
        return $this->ruleEntity;
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
        if ($this->condition->match($product, $this->ruleEntity)) {
            $value = $this->generator->generateAttributeValue($product);
            $product->setAttributeValue($this->getAttribute(), $value);
            return true;
        }
        return false;
    }
}