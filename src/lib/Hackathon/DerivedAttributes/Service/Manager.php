<?php
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;
use Hackathon\DerivedAttributes\ServiceInterface\ConditionInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class Manager
{
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
                $result[$id] = ['title' => $generator->getTitle(), 'description' => $generator->getDescription()];
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
}