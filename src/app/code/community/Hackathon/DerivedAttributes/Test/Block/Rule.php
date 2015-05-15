<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Block_Rule extends EcomDev_PHPUnit_Test_Case_Controller
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
        $this->assertResponseBodyContains('/derivedAttributes_entity/index', '"Apply rules" link should be present');
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
        $this->assertResponseBodyContains('value="template"', 'Dropdown with generator types should be present');
        $this->assertResponseBodyContains('value="boolean-attribute"', 'Dropdown with condition types should be present');
        $this->assertResponseBodyContains('<option value="0">All', 'Select box for store views should contain "All Store Views"');

        $this->assertResponseBodyContains('<optgroup label="Customer"', 'Dropdown with attribute ids should contain customer optgroup');
        $this->assertResponseBodyContains('<optgroup label="Product"', 'Dropdown with attribute ids should contain product optgroup');
        $this->assertResponseBodyContains('value="72"', 'Dropdown with attribute ids should contain product description attribute id');
        $this->assertResponseBodyNotContains('value="111"', 'Dropdown with attribute ids should not contain product has_options attribute id (invisible)');
        $this->assertResponseBodyContains('value="5"', 'Dropdown with attribute ids should contain customer first name attribute id');
        $this->assertResponseBodyNotContains('value="16"', 'Dropdown with attribute ids should not contain customer confirmation attribute id (invisible)');
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
        $this->dispatch('adminhtml/derivedAttributes_rule/edit', ['id' => $ruleId]);
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
        $this->assertResponseBodyContains('value="Test Rule 1"', 'Name input should be filled');
        $this->assertResponseBodyContains('<option value="1" selected="selected">Active</option>', 'Status input should be set to active');
        $this->assertResponseBodyContains('This is a template generator rule for the product description');
    }
}