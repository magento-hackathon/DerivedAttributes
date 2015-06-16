<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class RuleBuilder
{
    private $serviceManager;

    private $priority;
    private $condition;
    private $generator;
    private $attribute;

    /**
     * @param Manager $serviceManager
     */
    public function __construct(Manager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        //TODO set default values, expect other required attribute as constructor args
    }
    /**
     * @param $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    /**
     * @param GeneratorInterface $generator
     * @return $this
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
        return $this;
    }
    /**
     * @param ConditionInterface $condition
     * @return $this
     */
    public function setCondition(ConditionInterface $condition)
    {
        $this->condition = $condition;
        return $this;
    }
    public function buildCondition($conditionType, $conditionData)
    {
        $this->setCondition($this->serviceManager->getCondition($conditionType, $conditionData));
        return $this;
    }
    public function buildGenerator($generatorType, $generatorData)
    {
        $this->setGenerator($this->serviceManager->getGenerator($generatorType, $generatorData));
        return $this;
    }
    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @return Rule
     */
    public function build()
    {
        return new Rule($this->priority, $this->attribute, $this->condition, $this->generator);
    }
}