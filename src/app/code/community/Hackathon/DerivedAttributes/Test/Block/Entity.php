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
    public function formForApplyRulesShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_entity');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/index');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_entity_index');
        $this->assertLayoutBlockRendered('derivedattributes_entity', 'Container should be instantiated');
        $this->assertLayoutBlockRendered('derivedattributes_entity_form', 'Form should be instantiated');
        $this->assertLayoutBlockRendered('derivedattributes_entity_tabs', 'Tabs should be instantiated');
        $this->assertResponseBodyContains('<option value="apply">', 'Grid should contain mass action "apply".');
        $this->assertResponseBodyContains('<option value="dryrun">', 'Grid should contain mass action "dryrun".');
        $this->assertResponseBodyContains('name="entity_type"', 'Mass action block should contain hidden input with entity type');
        // assertLayoutBlockRendered does not work with blocks created from code (i.e. the grids)
    }
}