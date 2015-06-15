<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
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
    /**
     * @param RuleInterface $generatorEntity
     * @return $this
     */
    public function setGeneratorFromEntity(RuleInterface $generatorEntity)
    {
        $this->generator = $this->serviceManager->getGeneratorFromEntity($generatorEntity);
        return $this;
    }
    /**
     * @param RuleInterface $conditionEntity
     * @return $this
     */
    public function setConditionFromEntity(RuleInterface $conditionEntity)
    {
        $this->condition = $this->serviceManager->getConditionFromEntity($conditionEntity);
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