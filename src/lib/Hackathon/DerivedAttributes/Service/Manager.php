<?php
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;
use Hackathon\DerivedAttributes\Service\Condition\AlwaysCondition;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class Manager
{
    const __CLASS = __CLASS__;

    private $generatorTypes = [];
    private $conditionTypes = [];

    public function __construct(){
        $this->resetGeneratorTypes();
        $this->resetConditionTypes();
    }

    public function resetGeneratorTypes(){
        $this->generatorTypes = [
            'template' => TemplateGenerator::__CLASS
        ];
    }

    public function resetConditionTypes(){
        $this->conditionTypes = [
            'boolean-attribute' => BooleanAttributeCondition::__CLASS,
            'always' => AlwaysCondition::__CLASS
        ];
    }

    public function getGeneratorTypes(){
        return $this->generatorTypes;
    }

    public function addGeneratorType($id, $class){
        if(is_object($class)){
            $class = get_class($class);
        }
        $this->generatorTypes[(string)$id] = $class;
    }

    public function getConditionTypes(){
        return $this->conditionTypes;
    }

    public function addConditionType($id, $class){
        if(is_object($class)){
            $class = get_class($class);
        }
        $this->conditionTypes[(string)$id] = $class;
    }

    /**
     * Return meta information of available generators
     *
     * @return array as [ $identifier => [ "title" => $title, "description" => $description ]
     */
    public function getAvailableGeneratorTypes()
    {
        $result = array();
        foreach ($this->generatorTypes as $id => $class) {
            if (is_subclass_of($class, GeneratorInterface::__INTERFACE)) {
                $generator = new $class;
                $result[$id] = [
                    'title' => $generator->getTitle(), 
                    'description' => $generator->getDescription()
                ];
            }
        }
        return $result;
    }

    /**
     * Return meta information of available generators
     *
     * @return array as [ $identifier => [ "title" => $title, "description" => $description ]
     */
    public function getAvailableConditionTypes()
    {
        $result = array();
        foreach ($this->conditionTypes as $id => $class) {
            if (is_subclass_of($class, ConditionInterface::__INTERFACE)) {
                $condition = new $class;
                $result[$id] = ['title' => $condition->getTitle(), 'description' => $condition->getDescription()];
            }
        }
        return $result;
    }

    /**
     * Factory method: instantiate condition based on bridge interface
     *
     * @param $conditionType
     * @param $conditionData
     * @return ConditionInterface
     */
    public function getCondition($conditionType, $conditionData)
    {
        if (!isset($this->conditionTypes[$conditionType])) {
            throw new \InvalidArgumentException(sprintf('Unknown condition type "%s".', $conditionType));
        }
        /** @var ConditionInterface $condition */
        $condition = new $this->conditionTypes[$conditionType];
        $condition->configure($conditionData);
        return $condition;
    }

    /**
     * Factory method: instantiate generator based on bridge interface
     *
     * @param $generatorType
     * @param $generatorData
     * @return GeneratorInterface
     */
    public function getGenerator($generatorType, $generatorData)
    {
        if (!isset($this->generatorTypes[$generatorType])) {
            throw new \InvalidArgumentException(sprintf('Unknown generator type "%s".', $generatorType));
        }
        /** @var GeneratorInterface $generator */
        $generator = new $this->generatorTypes[$generatorType];
        $generator->configure($generatorData);
        return $generator;
    }

    /**
     * Determine condition type identifier based on condition instance
     *
     * @param ConditionInterface $condition
     * @return string
     * @throws \OutOfBoundsException
     */
    public function getConditionType(ConditionInterface $condition)
    {
        $result = array_search(get_class($condition), $this->conditionTypes);
        if ($result === false) {
            throw new \OutOfBoundsException('Condition type not registered.');
        }
        return $result;
    }

    /**
     * Determine generator type identifier based on generator instance
     *
     * @param GeneratorInterface $generator
     * @return string
     * @throws \OutOfBoundsException
     */
    public function getGeneratorType(GeneratorInterface $generator)
    {
        $result = array_search(get_class($generator), $this->generatorTypes);
        if ($result === false) {
            throw new \OutOfBoundsException('Generator type not registered.');
        }
        return $result;
    }
}
