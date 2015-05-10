<?php
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
    }

    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     */
    public function newFormShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule/new');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
    }
}