<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Block_Grid extends EcomDev_PHPUnit_Test_Case_Controller
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
        $this->dispatch('adminhtml/derivedAttributes_rule');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/index');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_index');
        $this->assertLayoutBlockCreated('derivedattributes_rule', 'Grid container should be instantiated');
        $this->assertResponseBodyNotContains('empty-text', 'Grid content should not be empty');
        $this->assertResponseBodyContains('Test Rule 1');
    }

    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     * @registry current_derived_attribute_rule
     */
    public function newFormShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule/new');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
    }
    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     * @registry current_derived_attribute_rule
     */
    public function editFormShouldBeLoaded()
    {
        $ruleId = 1;
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule/edit', [ 'id' => $ruleId ]);
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
        $this->assertResponseBodyContains('Test Rule 1');
    }
}