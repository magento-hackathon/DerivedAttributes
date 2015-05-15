<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Block_Entity extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     */
    public function gridShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_entity');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/index');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_entity_index');
        $this->assertLayoutBlockCreated('derivedattributes_entity', 'Container should be instantiated');
        $this->assertLayoutBlockCreated('derivedattributes_entity_tabs', 'Tabs should be instantiated');
    }
}