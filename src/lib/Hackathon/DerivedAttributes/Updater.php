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
     * @var RuleSetsByStore
     */
    private $ruleSets;
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
     * @param Store $store
     */
    public function update(EntityInterface $entity, Store $store)
    {
        $ruleSets = $this->getRuleSets(new StoreSet([$store]));
        $ruleSets->getRuleSet($store)->applyToEntity($entity, $this->ruleLogger);
    }

    /**
     * Update entity collection based on loaded rule set
     *
     * @param EntityIteratorInterface $iterator
     * @param EntityInterface $entityModel
     */
    public function massUpdate(EntityIteratorInterface $iterator, EntityInterface $entityModel, StoreSet $stores)
    {
        $this->entityModel = $entityModel;
        $this->outputStart();
        $this->getRuleSets($stores);
        foreach ($stores as $store) {
            $iterator->setStore($store);
            foreach ($iterator as $entityData) {
                $this->updateCurrentRow($entityData, $store);
                $this->outputIteratorStatus($iterator);
            }
        }
        $this->outputDone();
        $this->entityModel = null;
    }

    /**
     * Update current row of entity collection
     *
     * @param array $data
     * @param Store $store
     * @internal param EntityIteratorInterface $iterator
     */
    private function updateCurrentRow(array $data, Store $store)
    {
        $this->entityModel->setRawData($data);
        $this->update($this->entityModel, $store);
        if ($this->entityModel->isChanged() && ! $this->isDryRun) {
            $this->entityModel->saveAttributes();
        }
        $this->entityModel->clearInstance();
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

    /**
     * @return RuleSetsByStore
     */
    private function getRuleSets(StoreSet $stores)
    {
        if ($this->ruleSets === null) {
            $this->ruleSets = $this->ruleRepository->findRuleSetsForStores($stores);
        }
        return $this->ruleSets;
    }
}