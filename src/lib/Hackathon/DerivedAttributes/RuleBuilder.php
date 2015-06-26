<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class RuleBuilder
{
    private $serviceManager;

    // default properties
    private $active        = true;
    private $priority      = 0;
    private $name          = 'New Rule';
    private $description   = '';
    private $conditionType = 'always';
    private $conditionData = '';
    private $generatorType = 'template';
    private $generatorData = '';

    private $condition;
    private $generator;
    private $attribute;
    private $stores;

    /**
     * @param Manager $serviceManager
     */
    public function __construct(Manager $serviceManager, Attribute $attribute)
    {
        $this->serviceManager = $serviceManager;
        $this->attribute = $attribute;
        $this->stores = StoreSet::all();
    }

    /**
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
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
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $conditionType
     * @return $this
     */
    public function setConditionType($conditionType)
    {
        $this->conditionType = $conditionType;
        return $this;
    }

    /**
     * @param mixed $conditionData
     * @return $this
     */
    public function setConditionData($conditionData)
    {
        $this->conditionData = $conditionData;
        return $this;
    }

    /**
     * @param mixed $generatorType
     * @return $this
     */
    public function setGeneratorType($generatorType)
    {
        $this->generatorType = $generatorType;
        return $this;
    }

    /**
     * @param mixed $generatorData
     * @return $this
     */
    public function setGeneratorData($generatorData)
    {
        $this->generatorData = $generatorData;
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
     * @return $this
     */
    private function buildCondition()
    {
        if ($this->condition === null) {
            $this->setCondition($this->serviceManager->getCondition($this->conditionType, $this->conditionData));
        }
        return $this;
    }

    /**
     * @return $this
     */
    private function buildGenerator()
    {
        if ($this->generator === null) {
            $this->setGenerator($this->serviceManager->getGenerator($this->generatorType, $this->generatorData));
        }
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

    public function setStores(StoreSet $stores)
    {
        $this->stores = $stores;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
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
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return mixed
     */
    public function getGenerator()
    {
        return $this->generator;
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
     * @return Rule
     */
    public function build()
    {
        $this->buildCondition();
        $this->buildGenerator();
        $rule = new Rule($this);
        return $rule;
    }
}