<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoaderInterface;

class Updater
{
    /**
     * @var RuleLoaderInterface
     */
    private $ruleLoader;

    /**
     * @var EntityInterface
     */
    private $entityModel;

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
        if ($this->entityModel->isChanged()) {
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