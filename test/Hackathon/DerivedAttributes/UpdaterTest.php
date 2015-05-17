<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoaderInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoggerInterface;
use Hackathon\DerivedAttributes\Mock\CollectionMock;

class UpdaterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getCollectionData
     */
    public function testMassUpdate($collectionData)
    {
        $entityCount = count($collectionData);

        $ruleLogger = $this->getMockForAbstractClass(RuleLoggerInterface::__INTERFACE);
        $entityModel = $this->getMockForAbstractClass(EntityInterface::__INTERFACE);
        $ruleSet = $this->getMock(RuleSet::__CLASS, array('applyToEntity'));
        $ruleSet->expects($this->exactly($entityCount))->method('applyToEntity')->with($entityModel, $ruleLogger);
        $ruleLoader = $this->getMockForAbstractClass(RuleLoaderInterface::__INTERFACE);
        $ruleLoader->expects($this->atLeastOnce())->method('getRuleSet')->willReturn($ruleSet);

        foreach ($collectionData as $i => $entityData) {
            $entityModel->expects($this->at($i * 4))->method('setRawData')->with($entityData);
            $entityModel->expects($this->at($i * 4 + 1))->method('isChanged')->willReturn(true);
            $entityModel->expects($this->at($i * 4 + 2))->method('saveAttributes');
            $entityModel->expects($this->at($i * 4 + 3))->method('clearInstance');
        }
        $entityModel->expects($this->exactly($entityCount))->method('isChanged');
        $entityModel->expects($this->exactly($entityCount))->method('setRawData');
        $entityModel->expects($this->exactly($entityCount))->method('saveAttributes');
        $entityModel->expects($this->exactly($entityCount))->method('clearInstance');

        $collectionIterator = new CollectionMock($collectionData);

        $updater = new Updater($ruleLoader, $ruleLogger);
        $updater->massUpdate($collectionIterator, $entityModel);
    }

    /**
     * @test
     * @dataProvider getCollectionData
     */
    public function testDryRun($collectionData)
    {
        $entityCount = count($collectionData);

        $ruleLogger = $this->getMockForAbstractClass(RuleLoggerInterface::__INTERFACE);
        $entityModel = $this->getMockForAbstractClass(EntityInterface::__INTERFACE);
        $ruleSet = $this->getMock(RuleSet::__CLASS, array('applyToEntity'));
        $ruleSet->expects($this->exactly($entityCount))->method('applyToEntity')->with($entityModel, $ruleLogger);
        $ruleLoader = $this->getMockForAbstractClass(RuleLoaderInterface::__INTERFACE);
        $ruleLoader->expects($this->atLeastOnce())->method('getRuleSet')->willReturn($ruleSet);

        foreach ($collectionData as $i => $entityData) {
            $entityModel->expects($this->at($i * 3))->method('setRawData')->with($entityData);
            $entityModel->expects($this->at($i * 3 + 1))->method('isChanged')->willReturn(true);
            $entityModel->expects($this->at($i * 3 + 2))->method('clearInstance');
        }
        $entityModel->expects($this->exactly($entityCount))->method('isChanged');
        $entityModel->expects($this->exactly($entityCount))->method('setRawData');
        $entityModel->expects($this->never())->method('saveAttributes');
        $entityModel->expects($this->exactly($entityCount))->method('clearInstance');

        $collectionIterator = new CollectionMock($collectionData);

        $updater = new Updater($ruleLoader, $ruleLogger);
        $updater->setDryRun(true);
        $updater->massUpdate($collectionIterator, $entityModel);
    }

    /**
     * Data provider. Data of entities doesn't matter as long as it's unique, since ruleset and entity model
     * are mocked.
     *
     * @return array
     */
    public static function getCollectionData()
    {
        return array(
            array(
                'collectionData' => array(
                    array('entity_id' => 1, 'sku' => 'test-1'),
                    array('entity_id' => 2, 'sku' => 'test-2'),
                    array('entity_id' => 3, 'sku' => 'test-3'),
                    array('entity_id' => 4, 'sku' => 'test-4'),
                    array('entity_id' => 5, 'sku' => 'test-5'),
                )
            )
        );
    }
}