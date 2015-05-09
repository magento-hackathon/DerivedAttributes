<?php
namespace Hackathon\DerivedAttributes\Service;

use Hackathon\DerivedAttributes\Service\Generator\TemplateGenerator;
use Hackathon\DerivedAttributes\Service\Generator\Condition\BooleanAttributeCondition;

class Manager
{
    private $generatorTypes = [
        'template' => TemplateGenerator::__CLASS
    ];
    private $conditionTypes = [
        'boolean_attribute' => BooleanAttributeCondition::__CLASS
    ];
    public function getAvailableGeneratorTypes()
    {
        //TODO implement
    }
    public function getAvailableConditionTypes()
    {
        //TODO implement
    }
}