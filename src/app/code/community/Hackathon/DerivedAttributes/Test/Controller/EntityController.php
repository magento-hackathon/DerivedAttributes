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
     * @loadFixture products.yaml
     * @singleton adminhtml/session
     * @singleton admin/session
     */
    public function massUpdateShouldBeTriggered()
    {
        $updaterMock = $this->getModelMock('derivedattributes/massupdater', ['update']);
        $updaterMock->expects($this->once())->method('update')
            ->with([1, 2, 3], 'catalog_product', false);
        $this->replaceByMock('model', 'derivedattributes/massupdater', $updaterMock);

        $this->adminSession();
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost(array(
            'entity_ids'  => [1, 2, 3],
            'entity_type' => 'catalog_product'
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
        $this->assertResponseBodyJsonMatch(array('final' => true));
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