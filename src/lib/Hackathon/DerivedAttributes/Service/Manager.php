<?php
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\BridgeInterface\RuleConditionInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleGeneratorInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class Manager
{
    const __CLASS = __CLASS__;

    private $generatorTypes = [
        'template' => TemplateGenerator::__CLASS
    ];
    private $conditionTypes = [
        'boolean-attribute' => BooleanAttributeCondition::__CLASS
    ];

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
                    'description' => $generator->getDescription(),
                    'generator' => $generator
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
     * @param RuleConditionInterface $conditionEntity
     * @return ConditionInterface
     */
    public function getConditionFromEntity(RuleConditionInterface $conditionEntity)
    {
        $type = $conditionEntity->getConditionType();
        if (!isset($this->conditionTypes[$type])) {
            throw new \InvalidArgumentException(sprintf('Unknown condition type "%s".', $type));
        }
        /** @var ConditionInterface $condition */
        $condition = new $this->conditionTypes[$type];
        $condition->configure($conditionEntity->getConditionData());
        return $condition;
    }

    /**
     * Factory method: instantiate generator based on bridge interface
     *
     * @param RuleGeneratorInterface $generatorEntity
     * @return GeneratorInterface
     */
    public function getGeneratorFromEntity(RuleGeneratorInterface $generatorEntity)
    {
        $type = $generatorEntity->getGeneratorType();
        if (!isset($this->generatorTypes[$type])) {
            throw new \InvalidArgumentException(sprintf('Unknown generator type "%s".', $type));
        }
        /** @var GeneratorInterface $generator */
        $generator = new $this->generatorTypes[$type];
        $generator->configure($generatorEntity->getGeneratorData());
        return $generator;
    }
}
