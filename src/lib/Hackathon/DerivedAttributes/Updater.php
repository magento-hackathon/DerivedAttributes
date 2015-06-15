<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoggerInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleRepositoryInterface;

class Updater
{
    const __CLASS = __CLASS__;
    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;
    /**
     * @var RuleLoggerInterface
     */
    private $ruleLogger;
    /**
     * @var bool
     */
    private $isDryRun = false;

    /**
     * @var EntityInterface
     */
    private $entityModel;

    public function __construct(RuleRepositoryInterface $ruleRepository, RuleLoggerInterface $ruleLogger)
    {
        $this->ruleRepository = $ruleRepository;
        $this->ruleLogger = $ruleLogger;
    }

    /**
     * Define if massUpdate() should run without actually saving data
     *
     * @param bool $isDryRun
     */
    public function setDryRun($isDryRun)
    {
        $this->isDryRun = $isDryRun;
    }

    /**
     * Update entity based on loaded rule set
     *
     * @param EntityInterface $entity
     */
    public function update(EntityInterface $entity)
    {
        $ruleSet = $this->ruleRepository->findActive();
        $ruleSet->applyToEntity($entity, $this->ruleLogger);
    }

    /**
     * Update entity collection based on loaded rule set
     *
     * @param EntityIteratorInterface $iterator
     * @param EntityInterface $entityModel
     */
    public function massUpdate(EntityIteratorInterface $iterator, EntityInterface $entityModel)
    {
        $this->entityModel = $entityModel;
        $this->outputStart();
        $iterator->walk(array($this, 'updateCurrentRow'));
        $this->outputDone();
        $this->entityModel = null;
    }
    /**
     * Update current row of entity collection (used as callback for iterator->walk())
     *
     * @internal
     * @param EntityIteratorInterface $iterator
     */
    public function updateCurrentRow(EntityIteratorInterface $iterator)
    {
        $this->entityModel->setRawData($iterator->getRawData());
        $this->update($this->entityModel);
        if ($this->entityModel->isChanged() && ! $this->isDryRun) {
            $this->entityModel->saveAttributes();
        }
        $this->entityModel->clearInstance();
        $this->outputIteratorStatus($iterator);
    }
    private function outputStart()
    {
        //TODO implement output/log
    }
    /**
     * @param EntityIteratorInterface $iterator
     */
    private function outputIteratorStatus(EntityIteratorInterface $iterator)
    {
        //TODO implement output/log
    }
    private function outputDone()
    {
        //TODO implement output/log
    }
}