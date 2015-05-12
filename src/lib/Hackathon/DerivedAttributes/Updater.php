<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoaderInterface;

class Updater
{
    /**
     * @var RuleLoaderInterface
     */
    private $ruleLoader;

    public function __construct(RuleLoaderInterface $ruleLoader)
    {
        $this->ruleLoader = $ruleLoader;
    }

    /**
     * Update entity based on loaded rule set
     *
     * @param EntityInterface $entity
     */
    public function update(EntityInterface $entity)
    {
        $ruleSet = $this->ruleLoader->getRuleset();
        $ruleSet->applyToEntity($entity);
    }
}