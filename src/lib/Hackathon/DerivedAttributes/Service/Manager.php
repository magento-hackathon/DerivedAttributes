<?php
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\Service\Condition\BooleanAttributeCondition;

class Manager
{
    private $generatorTypes = [
        'template' => TemplateGenerator::__CLASS
    ];
    private $conditionTypes = [
        'boolean-attribute' => BooleanAttributeCondition::__INTERFACE
    ];
    public function getAvailableGeneratorTypes()
    {
        return \array_keys($this->generatorTypes);
        //TODO implement
    }
    public function getAvailableConditionTypes()
    {
        return \array_keys($this->conditionTypes);
    }
}