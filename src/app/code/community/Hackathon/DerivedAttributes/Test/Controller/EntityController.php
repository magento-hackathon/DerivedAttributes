<?php
use Hackathon\DerivedAttributes\Updater;

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Controller_EntityController
    extends Hackathon_DerivedAttributes_Test_Case_Controller_Dom
{
    /**
     * @test
     * @dataProvider dataMassUpdateForm
     * @loadFixture products.yaml
     * @singleton adminhtml/session
     * @singleton admin/session
     */
    public function massUpdateShouldBeTriggered($postData, $expectedStoreIds)
    {
        $updaterMock = $this->getModelMock('derivedattributes/massupdater', ['update']);
        $updaterMock->expects($this->once())->method('update')
            ->with($postData['entity_ids'], $postData['entity_type'], $expectedStoreIds, false);
        $this->replaceByMock('model', 'derivedattributes/massupdater', $updaterMock);

        $this->adminSession();
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($postData);
        $this->dispatch('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertResponseHttpCode(200);
        $this->assertResponseHeaderContains('content-type', 'application/json');
        $this->assertResponseBodyJsonMatch(array('final' => false));

        $this->getRequest()->setPost(array());
        $this->dispatch('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertResponseHttpCode(200);
        $this->assertResponseHeaderContains('content-type', 'application/json');
        $this->assertResponseBodyJsonMatch(array('final' => true));
    }

    public static function dataMassUpdateForm()
    {
        return [
            [
                'postData' => [
                    'store_id'    => ['1'],
                    'entity_ids'  => ['1', '2', '3'],
                    'entity_type' => 'catalog_product'
                ],
                'expectedStoreIds' => ['1']
            ],
            [
                'postData' => [
                    'store_id'    => ['1', '2'],
                    'entity_ids'  => ['1', '2', '3'],
                    'entity_type' => 'catalog_product'
                ],
                'expectedStoreIds' => ['1', '2']
            ],
            [
                'postData' => [
                    'store_id'    => ['0'],
                    'entity_ids'  => ['1', '2', '3'],
                    'entity_type' => 'catalog_product'
                ],
                'expectedStoreIds' => ['0']
            ],
        ];
    }
    /**
     * @test
     * @loadFixture products.yaml
     * @singleton adminhtml/session
     * @singleton admin/session
     */
    public function invalidEntityType()
    {
        $this->adminSession();
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost(array(
            'entity_ids'  => [1, 2, 3],
            'entity_type' => 'invalid_entity_type'
        ));
        $this->dispatch('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertResponseHttpCode(200);
        $this->assertResponseHeaderContains('content-type', 'application/json');
        $this->assertResponseBodyJsonMatch(array('final' => false));

        $this->getRequest()->setPost(array());
        $this->dispatch('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/applyRules');
        $this->assertResponseHttpCode(200);
        $this->assertResponseHeaderContains('content-type', 'application/json');
        $this->assertResponseBodyJsonMatch(array('final' => true, 'error' => ''), 'Response should contain error');
    }
}