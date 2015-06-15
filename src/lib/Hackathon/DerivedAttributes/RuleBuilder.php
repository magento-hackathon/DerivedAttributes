<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Manager;

class RuleBuilder
{
    private $ruleEntity;
    private $serviceManager;

    public function __construct(RuleInterface $ruleEntity, Manager $serviceManager)
    {
        $this->ruleEntity = $ruleEntity;
        $this->serviceManager = $serviceManager;
    }
    public function build()
    {
        return new Rule($this->ruleEntity, $this->serviceManager);
    }
}