<?php
namespace Hackathon\DerivedAttributes;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoaderInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleLoggerInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleRepositoryInterface;
use Hackathon\DerivedAttributes\Mock\CollectionMock;

class UpdaterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataForMassUpdate
     * @param $collectionData
     * @param StoreSet $storeSet
     */
    public function testRealMassUpdate($collectionData, StoreSet $storeSet)
    {
        $this->_testMassUpdate($collectionData, $storeSet, false);
    }

    /**
     * @test
     * @dataProvider dataForMassUpdate
     * @param $collectionData
     * @param StoreSet $storeSet
     */
    public function testDryRun($collectionData, StoreSet $storeSet)
    {
        $this->_testMassUpdate($collectionData, $storeSet, true);
    }

    /**
     * Data provider. Data of entities doesn't matter as long as it's unique, since ruleset and entity model
     * are mocked.
     *
     * @return array
     */
    public static function dataForMassUpdate()
    {
        return array(
            array(
                'collectionData' => array(
                    array('entity_id' => 1, 'sku' => 'test-1'),
                    array('entity_id' => 2, 'sku' => 'test-2'),
                    array('entity_id' => 3, 'sku' => 'test-3'),
                    array('entity_id' => 4, 'sku' => 'test-4'),
                    array('entity_id' => 5, 'sku' => 'test-5'),
                ),
                'storeSets' => new StoreSet(['1'])
            ),
            array(
                'collectionData' => array(
                    array('entity_id' => 1, 'sku' => 'test-1'),
                    array('entity_id' => 2, 'sku' => 'test-2'),
                    array('entity_id' => 3, 'sku' => 'test-3'),
                    array('entity_id' => 4, 'sku' => 'test-4'),
                    array('entity_id' => 5, 'sku' => 'test-5'),
                ),
                'storeSets' => new StoreSet(['1', '2'])
            )
        );
    }

    /**
     * @param $collectionData
     * @param StoreSet $storeSet
     */
    private function _testMassUpdate($collectionData, StoreSet $storeSet, $dryRun)
    {
        $entityCount = count($collectionData);

        $ruleLogger = $this->getMockForAbstractClass(RuleLoggerInterface::__INTERFACE);
        $entityModel = $this->getMockForAbstractClass(EntityInterface::__INTERFACE);

        $ruleSetsByStore = new RuleSetsByStore();
        foreach ($storeSet as $store) {
            $ruleSet = $this->getMock(RuleSet::__CLASS, array('applyToEntity'));
            $ruleSet->expects($this->exactly($entityCount))
                ->method('applyToEntity')
                ->with($entityModel, $ruleLogger);
            $ruleSetsByStore->addRuleSet($ruleSet, $store);
        }
        $ruleRepository = $this->getMockForAbstractClass(RuleRepositoryInterface::__INTERFACE);
        $ruleRepository->expects($this->atLeastOnce())
            ->method('findRuleSetsForStores')
            ->with($storeSet)
            ->willReturn($ruleSetsByStore);

        $collectionIterator = new CollectionMock($collectionData);

        $updater = new Updater($ruleRepository, $ruleLogger);
        $updater->setDryRun($dryRun);
        if ($dryRun) {
            $this->setUpEntityMockForDryRun($collectionData, $entityModel, $entityCount, count($storeSet));
        } else {
            $this->setUpEntityMock($collectionData, $entityModel, $entityCount, count($storeSet));
        }

        $updater->massUpdate($collectionIterator, $entityModel, $storeSet);
    }

    /**
     * @param $collectionData
     * @param $entityModel
     * @param $entityCount
     */
    private function setUpEntityMock($collectionData, $entityModel, $entityCount, $storeCount)
    {
        for ($i = 0; $i < $storeCount; ++$i) {
            foreach ($collectionData as $k => $entityData) {
                $pivot = ($i * $entityCount + $k) * 4;
                $entityModel->expects($this->at($pivot))->method('setRawData')->with($entityData);
                $entityModel->expects($this->at($pivot + 1))->method('isChanged')->willReturn(true);
                $entityModel->expects($this->at($pivot + 2))->method('saveAttributes');
                $entityModel->expects($this->at($pivot + 3))->method('clearInstance');
            }
        }
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('isChanged');
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('setRawData');
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('saveAttributes');
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('clearInstance');
    }

    /**
     * @param $collectionData
     * @param $entityModel
     * @param $entityCount
     * @return CollectionMock
     */
    private function setUpEntityMockForDryRun($collectionData, $entityModel, $entityCount, $storeCount)
    {
        for ($i = 0; $i < $storeCount; ++$i) {
            foreach ($collectionData as $k => $entityData) {
                $pivot = ($i * $entityCount + $k) * 3;
                $entityModel->expects($this->at($pivot))->method('setRawData')->with($entityData);
                $entityModel->expects($this->at($pivot + 1))->method('isChanged')->willReturn(true);
                $entityModel->expects($this->at($pivot + 2))->method('clearInstance');
            }
        }
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('isChanged');
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('setRawData');
        $entityModel->expects($this->never())->method('saveAttributes');
        $entityModel->expects($this->exactly($entityCount * $storeCount))->method('clearInstance');
    }
}