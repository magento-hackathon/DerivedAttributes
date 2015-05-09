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

    function __construct(RuleInterface $ruleEntity, Manager $serviceManager)
    {
        $this->ruleEntity = $ruleEntity;
        //TODO add filters
        $this->attribute = $ruleEntity->getAttribute();
        $this->condition = $serviceManager->getConditionFromEntity($ruleEntity->getRuleCondition());
        $this->generator = $serviceManager->getGeneratorFromEntity($ruleEntity->getRuleGenerator());
        $this->priority = $ruleEntity->getPriority();
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
    public function applyToProduct(EntityInterface $product)
    {
        if ($this->condition->match($product, $this->ruleEntity)) {
            $value = $this->generator->generateAttributeValue($product, $this->ruleEntity);
            $product->setAttributeValue($this->getAttribute(), $value);
            return true;
        }
        return false;
    }
}